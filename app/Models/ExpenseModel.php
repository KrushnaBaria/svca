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
    protected $allowedFields    = [];

    public function add($data)
    {
        $query = "INSERT INTO expenses (id, exp, center, amount, add_date, updated_by, updated_date) VALUES (NULL, '" . $data['description'] . "', '" . $data['center_id'] . "', '" . $data['amount'] . "', NOW(), '" . auth()->user()->email . "', NOW())";
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

        $query = "SELECT e.*, c.center AS center_name
                  FROM expenses e 
                  JOIN centers c ON e.center = c.id ";

        if(!empty($search)){
            $query .= " WHERE e.exp LIKE '%" . $search . "%' OR c.center LIKE '%" . $search . "%' ";
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

    public function getPERinfo()
    {
        $revenue_query = "SELECT SUM(amount) AS revenue
                    FROM payment
                    WHERE DATE_FORMAT(add_date, '%Y-%m') = '2026-01'
                    GROUP BY YEAR(add_date), MONTH(add_date)";
        
        $expense_query = "SELECT SUM(amount) AS expenses
                    FROM expenses
                    WHERE DATE_FORMAT(add_date, '%Y-%m') = '2026-01'
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
}
