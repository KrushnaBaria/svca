<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Models\ExpenseModel;
use App\Models\CenterModel;
use App\Models\UserModel;
use App\Models\UserInfoModel;
use App\Models\ExpenseLog;

class Expense extends BaseController
{
    protected $model;
    protected $centertModel;
    protected $userModel;
    protected $userInfoModel;
    protected $expenseModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->model = model(ExpenseModel::class);
        $this->centerModel = model(CenterModel::class);
        $this->userModel = model(UserModel::class);
        $this->userInfoModel = model(UserInfoModel::class);
        $this->expenseModel = model(ExpenseLog::class);
    }

    public function index()
    {   
        if(Auth()->user()->inGroup('superadmin')){
            $data['centers'] = $this->centerModel->findAll();
            $data['users'] = $this->userModel->getUsers();
        }else{
            $u_details = $this->userInfoModel->curUserDetail();
            $data['centers'] = $this->centerModel->where('id', $u_details['center'])->findAll();
            $users = $this->userModel->getUsers();
            // Only include the user whose id matches $u_details['user_id'], if present
            $data['users'] = array_filter($users ?? [], function($user) use ($u_details) {
                return isset($u_details['user_id']) && $user['id'] == $u_details['user_id'];
            });
        }
        
        return view('template/header', ['page_title' => 'Expense']) . view('expense/expense', $data) . view('template/footer', ['app_init' => 'initExpense']);
    }

    public function add()
    {   
        $exp_id = $this->request->getPost('exp_id');
        $data = [
            'exp' => $this->request->getPost('exp'),
            'center' => $this->request->getPost('center'),
            'amount' => $this->request->getPost('amount')
        ];

        if($exp_id){
            $data = array_merge($data, [
                'updated_by' => auth()->user()->email,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
        }

        if($exp_id){
            $log = $this->expenseModel->add_log($exp_id, $data);
            if($log){
                $upd = $this->model->update($exp_id, $data);
                if($upd){
                    return json_encode(['success' => '1', 'message' => 'Expense updated successfully']);
                } else {
                    return json_encode(['success' => '0', 'message' => 'Failed to updated expense']);
                }
            }else{
                return json_encode(['success' => '0', 'message' => 'Failed to update log']);
            }
        }else{
            if($this->model->add($data)){
                return json_encode(['success' => '1', 'message' => 'Expense added successfully']);
            } else {
                return json_encode(['success' => '0', 'message' => 'Failed to add expense']);
            }
        }
    }

    public function list()
    {
        $data = [
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('length'),
            'search' => $this->request->getPost('search')['value'] ?? '',
            'center_ftr' => $this->request->getPost('center_ftr'),
            'user_ftr' => $this->request->getPost('user_ftr'),
            'date_ftr' => $this->request->getPost('date_ftr'),
        ];

        $expenses = $this->model->getList($data);
        if($expenses){
            return json_encode($expenses);
        } else {
            return json_encode();
        }
    }

    public function importCsv()
    {
        $file = $this->request->getFile('expense_csv_file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => 0, 'message' => 'Please upload a CSV file.']);
        }

        if (strtolower($file->getClientExtension()) !== 'csv') {
            return $this->response->setJSON(['success' => 0, 'message' => 'Only CSV files are allowed.']);
        }

        $handle = fopen($file->getTempName(), 'r');
        if (!$handle) {
            return $this->response->setJSON(['success' => 0, 'message' => 'Unable to read uploaded file.']);
        }

        $inserted = 0;
        $skipped  = 0;
        $errors   = [];
        $rowNum   = 0;

        $db = $this->model->db;
        $db->transBegin();

        $parseDate = function (string $raw) {
            $raw = trim($raw);
            if ($raw === '') {
                return null;
            }

            $dt = \DateTime::createFromFormat('Y-m-d', $raw) ?: \DateTime::createFromFormat('d-m-Y', $raw) ?: \DateTime::createFromFormat('d/m/Y', $raw);

            if (!$dt) {
                return null;
            }

            return $dt->format('Y-m-d H:i:s');
        };

        if (($header = fgetcsv($handle)) === false) {
            fclose($handle);
            return $this->response->setJSON(['success' => 0, 'message' => 'CSV file is empty.']);
        }

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;

            if (count($row) < 5) {
                $errors[] = "Row {$rowNum}: Not enough columns.";
                continue;
            }

            $expDesc   = trim($row[1] ?? '');
            $centerRaw = trim($row[2] ?? '');
            $amountRaw = trim($row[3] ?? '');
            $dateRaw   = trim($row[4] ?? '');

            $amount = is_numeric($amountRaw) ? (float) $amountRaw : null;
            $addDate = $parseDate($dateRaw);

            if ($expDesc === '' || $centerRaw == '' || $amount === null || $amount <= 0 || !$addDate) {
                $errors[] = "Row {$rowNum}: Invalid Description / Center / Amount / Date";
                continue;
            }

            $center = $this->centerModel->where('center', $centerRaw)->first();

            if (!$center) {
                $errors[] = "Row {$rowNum}: Center not found.";
                continue;
            }

            $res = $this->model->add([
                'exp'           => $expDesc,
                'center'        => $center['id'],
                'amount'        => $amount,
                'add_date'      => $addDate,
                'updated_by'    => 'import@svca.com',
                'updated_date'  => $addDate,
            ], false);

            if ($res) {
                $inserted++;
            } else {
                $errors[] = "Row {$rowNum}: Failed to insert expense.";
            }
        }

        fclose($handle);

        if (!empty($errors)) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => 0,
                'message' => 'Import failed. No expenses were imported due to errors.',
                'errors'  => $errors,
            ]);
        }

        $db->transCommit();

        return $this->response->setJSON([
            'success'  => 1,
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'errors'   => $errors,
        ]);
    }
}
