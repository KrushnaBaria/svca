<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function addStudent($data)
    {
        // Convert dob from d/m/Y to Y-m-d
        $dob = \DateTime::createFromFormat('d/m/Y', $data['dob']);
        $dobFormatted = $dob ? $dob->format('Y-m-d') : null;

        $query = "INSERT INTO students (id, name, fname, mname, dob, gender, cast, course, lqualifi, per, pnumber, apnumber, adhar, admi_date, batch_time, district, address, center, referred_by, status) VALUES (NULL, '" . $data['s_name'] . "', '" . $data['f_name'] . "', '" . $data['m_name'] . "', '" . $dobFormatted . "', '" . $data['gender'] . "', '" . $data['cast'] . "', '" . $data['course'] . "', '" . $data['lst_qulifi'] . "', '" . $data['per'] . "', '" . $data['p_number'] . "', '" . $data['ap_number'] . "', '" . $data['adhar'] . "', '". $data['adm_date'] ."', '" . $data['b_time'] . "', '" . $data['dist'] . "', '" . $data['address'] . "', '" . $data['center'] . "', '" . $data['ref_by'] . "', 1)";
        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }    
    
    }

    public function getStudents($data = [])
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $query = "SELECT st.*, courses.course AS course_name, centers.center AS center_name FROM students AS st
            LEFT JOIN centers ON st.center = centers.id
            LEFT JOIN courses ON st.course = courses.id
            WHERE status = 1";

        if (!empty($search)) {
            $query .= " AND (st.name LIKE '%" . $this->db->escapeLikeString($search) . "%' OR st.fname LIKE '%" . $this->db->escapeLikeString($search) . "%')";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY st.id DESC LIMIT " . (int)$start . ", " . (int)$end;

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }
    // {
    //     $query = "SELECT st.*, courses.course AS course_name, centers.center AS center_name FROM students AS st
    //         LEFT JOIN centers ON st.center = centers.id
    //         LEFT JOIN courses ON st.course = courses.id
    //         -- LEFT JOIN districts ON students.district = districts.id
    //         WHERE status = 1 ORDER BY st.id DESC"; ;
    //     $result = $this->db->query($query)->getResultArray();
    //     return $result;
    // }
}
