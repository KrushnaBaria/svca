<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table            = 'expenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'exp', 'center', 'amount', 'add_date', 'updated_by', 'updated_date'];

    public function add($data)
    {
        $query = "INSERT INTO expenses (id, exp, center, amount, add_date, updated_by, updated_date) VALUES (NULL, '" . $data['exp'] . "', '" . $data['center'] . "', '" . $data['amount'] . "', NOW(), '" . auth()->user()->email . "', NOW())";
         if($this->db->query($query)){
            return true;
        } else {
            return false;
        };
    }

    public function getList($data)
    {
        $start = $data['start'];
        $end = $data['end'];
        $search = $data['search'];

        // If date_ftr is set as a string like "21-01-2026 to 28-01-2026", convert it to start and end dates
        $date_ftr = isset($data['date_ftr']) ? trim($data['date_ftr']) : '';
        $start_date = '';
        $end_date = '';

        if (!empty($date_ftr)) {
            $parts = explode('to', $date_ftr);
            $start_date = $parts[0];
            $end_date = $parts[1];
        }

        $center_ad = '';
        if(!Auth()->user()->inGroup('superadmin')){
            $query1 = "SELECT center FROM user_info WHERE user_id = ". auth()->user()->id ."";
            $center_ad = $this->db->query($query1)->getResultArray();
            if($center_ad){
                $center_ad = $center_ad[0]['center'];
            }
        }

        $query = "SELECT e.*, c.center AS center_name
                  FROM expenses e 
                  JOIN centers c ON e.center = c.id
                  WHERE 1=1";

        if($center_ad){
            $query .= " AND e.center = " . $center_ad . "";
        }

        if($data['center_ftr']){
            $query .= " AND e.center = " . $data['center_ftr'] . "";
        }

        if($data['user_ftr']){
            $query .= " AND e.updated_by = '" . $data['user_ftr'] . "'";
        }

        if(!empty($search)){
            $query .= " AND e.exp LIKE '%" . $search . "%' OR c.center LIKE '%" . $search . "%' ";
        }

        if($start_date && $end_date){
            $query .= " AND DATE(e.add_date) BETWEEN '" . trim($start_date) . "' AND '" . trim($end_date) . "' ";
        }

        $query .= " ORDER BY e.id DESC LIMIT " . $start . ", " . $end;

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function getMainReportChartData()
    {
        $revenue_query = "SELECT DATE_FORMAT(add_date, '%b') AS month, MONTH(add_date) AS month_no, SUM(amount) AS revenue
                    FROM payment
                    GROUP BY YEAR(add_date), MONTH(add_date)
                    ORDER BY month_no;";
        
        $expense_query = "SELECT DATE_FORMAT(add_date, '%b') AS month, MONTH(add_date) AS month_no, SUM(amount) AS expenses
                    FROM expenses
                    GROUP BY YEAR(add_date), MONTH(add_date)
                    ORDER BY month_no;";

        $revenue_result = $this->db->query($revenue_query)->getResultArray();
        $expense_result = $this->db->query($expense_query)->getResultArray();
        
        // Combine revenue and expense by month, calculate profit

        // Build associative arrays for fast lookup
        $revenue_by_month = [];
        foreach ($revenue_result as $row) {
            $revenue_by_month[$row['month_no']] = [
                'month' => $row['month'],
                'revenue' => (float)$row['revenue']
            ];
        }

        $expense_by_month = [];
        foreach ($expense_result as $row) {
            $expense_by_month[$row['month_no']] = [
                'month' => $row['month'],
                'expenses' => (float)$row['expenses']
            ];
        }

        // Get list of all months present in either
        $months = array_unique(array_merge(array_keys($revenue_by_month), array_keys($expense_by_month)));
        sort($months, SORT_NUMERIC);

        $result = [];
        foreach ($months as $month_no) {
            $month_name = isset($revenue_by_month[$month_no]['month']) ? $revenue_by_month[$month_no]['month'] :
                        (isset($expense_by_month[$month_no]['month']) ? $expense_by_month[$month_no]['month'] : '');

            $revenue = isset($revenue_by_month[$month_no]['revenue']) ? $revenue_by_month[$month_no]['revenue'] : 0;
            $expenses = isset($expense_by_month[$month_no]['expenses']) ? $expense_by_month[$month_no]['expenses'] : 0;
            $profit = $revenue - $expenses;

            $result[] = [
                'month' => $month_name,
                'revenue' => $revenue,
                'expenses' => $expenses,
                'profit' => $profit
            ];
        }
        return $result;
    }

    public function getPERinfo($data)
    {
        $whereRev = $whereExp = '';

        if($data['center_id']){
            $whereRev .= " AND stu.center = '". $data['center_id'] ."'";
        }

        if($data['center_id']){
            $whereExp .= " AND center = '". $data['center_id'] ."'";
        }

        $revenue_query = "SELECT SUM(amount) AS revenue
                    FROM payment
                    LEFT JOIN students AS stu ON payment.stu_id = stu.id
                    WHERE 1=1". $whereRev . " AND DATE_FORMAT(payment.add_date, '%Y-%m') = '". $data['f_date'] ."'
                    GROUP BY YEAR(payment.add_date), MONTH(payment.add_date)";
        
        $expense_query = "SELECT SUM(amount) AS expenses
                    FROM expenses
                    WHERE 1=1". $whereExp . " AND DATE_FORMAT(add_date, '%Y-%m') = '". $data['f_date'] ."'
                    GROUP BY YEAR(add_date), MONTH(add_date)";

        $revenue_result = $this->db->query($revenue_query)->getResultArray();
        $expense_result = $this->db->query($expense_query)->getResultArray();

        $revenue_result = count($revenue_result) > 0 ? $revenue_result : [['revenue' => 0]];
        $expense_result = count($expense_result) > 0 ? $expense_result : [['expenses' => 0]];

        return [
            $revenue_result[0],
            $expense_result[0]
        ];
    }

    public function getTotalProfit($date)
    {
        $revenue_query = "SELECT SUM(amount) AS revenue
                    FROM payment
                    LEFT JOIN students AS stu ON payment.stu_id = stu.id
                    WHERE 1=1 AND DATE_FORMAT(payment.add_date, '%Y-%m') = '". $date ."'
                    GROUP BY YEAR(payment.add_date), MONTH(payment.add_date)";
        
        $expense_query = "SELECT SUM(amount) AS expenses
                    FROM expenses
                    WHERE 1=1 AND DATE_FORMAT(add_date, '%Y-%m') = '". $date ."'
                    GROUP BY YEAR(add_date), MONTH(add_date)";

        $revenue_result = $this->db->query($revenue_query)->getResultArray();
        $expense_result = $this->db->query($expense_query)->getResultArray();

        $revenue_result = count($revenue_result) > 0 ? $revenue_result : [['revenue' => 0]];
        $expense_result = count($expense_result) > 0 ? $expense_result : [['expenses' => 0]];

        if($revenue_result[0]['revenue'] && $expense_result[0]['expenses']){
            return [
                'revenue' => $revenue_result[0]['revenue'],
                'expenses' => $expense_result[0]['expenses'],
                'profit' => $revenue_result[0]['revenue'] - $expense_result[0]['expenses']
            ];
        } else {
            return false;
        }
    }
}
