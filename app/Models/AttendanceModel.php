<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table            = 'student_attendance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['stu_id', 'att_date', 'status', 'created_at', 'updated_at'];

    /**
     * Get active students with attendance status for a given date and filters.
     *
     * Expected $data keys:
     * - start, end           : DataTables paging
     * - search               : search string
     * - att_date             : Y-m-d date string (required)
     * - center_ftr (optional)
     * - type_ftr   (optional)
     */
    public function getStudentsForAttendance(array $data = [])
    {
        $start   = $data['start'] ?? 0;
        $end     = $data['end'] ?? 10;
        $search  = $data['search'] ?? '';
        $attDate = $data['att_date'] ?? '';

        if (empty($attDate)) {
            return [
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ];
        }

        $centerFilter = $data['center_ftr'] ?? '';
        $typeFilter   = $data['type_ftr'] ?? '';

        // Restrict to current user's center if not superadmin
        $center_ad = '';
        if (!auth()->user()->inGroup('superadmin')) {
            $query1    = "SELECT center FROM user_info WHERE user_id = " . auth()->user()->id;
            $centerRow = $this->db->query($query1)->getResultArray();
            if ($centerRow) {
                $center_ad = $centerRow[0]['center'];
            }
        }

        $query = "SELECT st.id,
                         st.name,
                         st.fname,
                         centers.center AS center_name,
                         courses.course AS course_name,
                         sa.status AS attendance_status
                  FROM students AS st
                  LEFT JOIN centers ON st.center = centers.id
                  LEFT JOIN courses ON st.course = courses.id
                  LEFT JOIN {$this->table} AS sa
                         ON sa.stu_id = st.id
                        AND sa.att_date = '" . $attDate . "'
                  WHERE st.status = 1
                    AND st.del_sts = 0";

        if ($center_ad) {
            $query .= " AND st.center = " . (int) $center_ad;
        }

        if (!empty($centerFilter)) {
            $query .= " AND st.center = " . (int) $centerFilter;
        }

        if (!empty($typeFilter)) {
            $query .= " AND courses.type LIKE '" . $this->db->escapeString($typeFilter) . "'";
        }

        if (!empty($search)) {
            $like = $this->db->escapeLikeString($search);
            $query .= " AND (st.name LIKE '%{$like}%' OR st.fname LIKE '%{$like}%')";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY st.id DESC";
        if ($end != -1) {
            $query .= " LIMIT " . (int) $start . ", " . (int) $end;
        }

        $result['data'] = $this->db->query($query)->getResultArray();

        return $result;
    }

    /**
     * Save attendance entries for a specific date.
     *
     * $attDate must be Y-m-d.
     * $items is an array of ['stu_id' => int, 'status' => 'present'|'absent'].
     */
    public function saveAttendanceForDate(string $attDate, array $items): bool
    {
        if (empty($attDate) || empty($items)) {
            return false;
        }

        $builder = $this->db->table($this->table);

        foreach ($items as $row) {
            if (empty($row['stu_id']) || empty($row['status'])) {
                continue;
            }

            $data = [
                'stu_id'    => (int) $row['stu_id'],
                'att_date'  => $attDate,
                'status'    => $row['status'] === 'present' ? 'present' : 'absent',
                'updated_at'=> date('Y-m-d H:i:s'),
            ];

            // Try update first, then insert if not existing
            $builder->set($data)
                    ->where('stu_id', $data['stu_id'])
                    ->where('att_date', $data['att_date'])
                    ->update();

            if ($this->db->affectedRows() === 0) {
                $data['created_at'] = date('Y-m-d H:i:s');
                $builder->insert($data);
            }
        }

        return true;
    }
}

