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
    protected $allowedFields    = ['id', 'name', 'fname', 'mname', 'dob', 'gender', 'marital_sts', 'cast', 'fees', 'course', 'lqualifi', 'per', 'pnumber', 'apnumber', 'adhar', 'admi_date', 'batch_time', 'district', 'address', 'center', 'referred_by', 'add_date', 'updated_by', 'updated_date', 'del_sts', 'status'];

    public function addStudent($data)
    {
        // Convert dob from d/m/Y to Y-m-d
        $dob = \DateTime::createFromFormat('d/m/Y', $data['dob']);
        $dobFormatted = $dob ? $dob->format('Y-m-d') : null;

        // Convert adm_date from d/m/Y to Y-m-d
        $adm_date = \DateTime::createFromFormat('d/m/Y', $data['adm_date']);
        $adm_dateFormatted = $adm_date ? $adm_date->format('Y-m-d') : null;

        $query = "INSERT INTO students (id, name, fname, mname, dob, gender, marital_sts, cast, fees, course, lqualifi, per, pnumber, apnumber, adhar, admi_date, batch_time, district, address, center, referred_by, add_date, updated_by, updated_date, del_sts, status) VALUES (NULL, '" . $data['s_name'] . "', '" . $data['f_name'] . "', '" . $data['m_name'] . "', '" . $dobFormatted . "', '" . $data['gender'] . "', '" . $data['marital_sts'] . "', '" . $data['cast'] . "', '" . $data['fees'] . "', '" . $data['course'] . "', '" . $data['lst_qulifi'] . "', '" . $data['per'] . "', '" . $data['p_number'] . "', '" . $data['ap_number'] . "', '" . $data['adhar'] . "', '". $adm_dateFormatted ."', '" . $data['b_time'] . "', '" . $data['dist'] . "', '" . $data['address'] . "', '" . $data['center'] . "', '" . $data['ref_by'] . "', '". date('Y-m-d H:i:s') ."', '" . $data['updated_by'] . "', '". date('Y-m-d H:i:s') ."', 0, 1)";
        if ($this->db->query($query)) {
            $student_id = $this->db->insertID();
            if($data['discount']){
                $amt = $data['fees'] * ($data['discount'] / 100);
                $pay_query = "INSERT INTO payment (id, stu_id, amount, remark, add_date, updated_by, updated_date) VALUES (NULL, " . intval($student_id) . ", " . floatval($amt) . ", '" . $data['discount'] . "% Discount Applied', '" . date('Y-m-d H:i:s') . "', 'AUTO', '" . date('Y-m-d H:i:s') . "')";
                if ($this->db->query($pay_query)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function getEditInfo($id)
    {
        $query = "SELECT st.*, courses.type AS course_type FROM students AS st
            LEFT JOIN courses ON st.course = courses.id
            WHERE st.id = ". $id ."";

        $result = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function updateStudent($id, $data, $remark)
    {
        // Convert dob from d/m/Y to Y-m-d
        $dob = \DateTime::createFromFormat('d/m/Y', $data['dob']);
        $dobFormatted = $dob ? $dob->format('Y-m-d') : null;

        // Convert adm_date from d/m/Y to Y-m-d
        $adm_date = \DateTime::createFromFormat('d/m/Y', $data['adm_date']);
        $adm_dateFormatted = $adm_date ? $adm_date->format('Y-m-d') : null;

        if($remark){
            $log_query = "INSERT INTO edit_log (id, remark, student_id, updated_date, updated_by) VALUES (NULL, '" . $remark . "', " . intval($id) . ", '" . date('Y-m-d H:i:s') . "', '" . $data['updated_by'] . "')";
            if($this->db->query($log_query)){
                // proceed to update student
            } else {
                return false;
            };
        }

        $query1 = "SELECT status FROM students WHERE id = " . intval($id);
        $result = $this->db->query($query1)->getRowArray();
        if($result['status'] == 0){
            if($data['discount']){
                $amt = $data['fees'] * ($data['discount'] / 100);
                $pay_query = "INSERT INTO payment (id, stu_id, amount, remark, add_date, updated_by, updated_date) VALUES (NULL, " . intval($id) . ", " . floatval($amt) . ", '" . $data['discount'] . "% Discount Applied', '" . date('Y-m-d H:i:s') . "', 'AUTO', '" . date('Y-m-d H:i:s') . "')";
                if ($this->db->query($pay_query)) {
                    // proceed to update student status
                } else {
                    return false;
                }
            }

            $query = "UPDATE students SET 
                        name = '" . $data['s_name'] . "',
                        fname = '" . $data['f_name'] . "',
                        mname = '" . $data['m_name'] . "',
                        dob = '" . $dobFormatted . "',
                        gender = '" . $data['gender'] . "',
                        marital_sts = '" . $data['marital_sts'] . "',
                        cast = '" . $data['cast'] . "',
                        course = '" . $data['course'] . "',
                        fees = '" . $data['fees'] . "',
                        lqualifi = '" . $data['lst_qulifi'] . "',
                        per = '" . $data['per'] . "',
                        pnumber = '" . $data['p_number'] . "',
                        apnumber = '" . $data['ap_number'] . "',
                        adhar = '" . $data['adhar'] . "',
                        admi_date = '". $adm_dateFormatted ."',
                        batch_time = '" . $data['b_time'] . "',
                        district = '" . $data['dist'] . "',
                        address = '" . $data['address'] . "',
                        center = '" . $data['center'] . "',
                        referred_by = '" . $data['ref_by'] . "',
                        updated_by = '" . $data['updated_by'] . "',
                        updated_date = NOW(),
                        status = 1
                        WHERE id = " . intval($id);
                    if ($this->db->query($query)) {
                        return true;
                    } else {
                        return false;
                    }
        }else{
            $query = "UPDATE students SET 
                name = '" . $data['s_name'] . "',
                fname = '" . $data['f_name'] . "',
                mname = '" . $data['m_name'] . "',
                dob = '" . $dobFormatted . "',
                gender = '" . $data['gender'] . "',
                marital_sts = '" . $data['marital_sts'] . "',
                cast = '" . $data['cast'] . "',
                lqualifi = '" . $data['lst_qulifi'] . "',
                per = '" . $data['per'] . "',
                pnumber = '" . $data['p_number'] . "',
                apnumber = '" . $data['ap_number'] . "',
                adhar = '" . $data['adhar'] . "',
                admi_date = '". $adm_dateFormatted ."',
                batch_time = '" . $data['b_time'] . "',
                district = '" . $data['dist'] . "',
                address = '" . $data['address'] . "',
                center = '" . $data['center'] . "',
                referred_by = '" . $data['ref_by'] . "',
                updated_by = '" . $data['updated_by'] . "',
                updated_date = NOW()
                WHERE id = " . intval($id);
            if ($this->db->query($query)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getStudents($data = [])
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $query = "SELECT st.*, courses.course AS course_name, centers.center AS center_name, courses.type AS course_type FROM students AS st
            LEFT JOIN centers ON st.center = centers.id
            LEFT JOIN courses ON st.course = courses.id
            WHERE status = 1 AND del_sts = 0";

        if (!empty($search)) {
            $query .= " AND (st.name LIKE '%" . $this->db->escapeLikeString($search) . "%' OR st.fname LIKE '%" . $this->db->escapeLikeString($search) . "%')";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY st.id DESC LIMIT " . (int)$start . ", " . (int)$end;

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function add_Inquiry($data){
        $query = "INSERT INTO students (id, name, fname, mname, dob, gender, cast, course, lqualifi, per, pnumber, apnumber, adhar, admi_date, batch_time, district, address, center, fees, referred_by, add_date, updated_by, updated_date, del_sts, status) VALUES (NULL, '" . $data['s_name'] . "', '', '', '', '', '', '" . $data['course'] . "', '" . $data['lst_qulifi'] . "', '', '" . $data['p_number'] . "', '', '', '', '', '', '', '" . $data['center'] . "', 0, '', NOW(), '". auth()->user()->email ."', NOW(), 0, 0)";
         if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }   
    }

    public function update_Inquiry($id, $data){
        $query = "UPDATE students SET name='" . $data['s_name'] . "', pnumber=" . $data['p_number'] . ", lqualifi='" . $data['lst_qulifi'] . "', course=" . $data['course'] . ", center=" . $data['center'] . ", updated_date = NOW(), updated_by = '" . auth()->user()->email . "' WHERE id=" . $id;
        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getInquerys($data = [])
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $query = "SELECT st.*, courses.course AS course_name, courses.type AS course_type, centers.center AS center_name FROM students AS st
            LEFT JOIN centers ON st.center = centers.id
            LEFT JOIN courses ON st.course = courses.id
            WHERE status = 0 AND del_sts = 0";

        if (!empty($search)) {
            $query .= " AND (st.name LIKE '%" . $this->db->escapeLikeString($search) . "%' OR st.pnumber LIKE '%" . $this->db->escapeLikeString($search) . "%')";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY st.id DESC LIMIT " . (int)$start . ", " . (int)$end;

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function getDeletedStudents($data = [])
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $query = "SELECT st.*, courses.course AS course_name, centers.center AS center_name, st.updated_by AS deleted_by, st.updated_date AS deleted_at FROM students AS st
            LEFT JOIN centers ON st.center = centers.id
            LEFT JOIN courses ON st.course = courses.id
            WHERE del_sts = 1 AND status = 1";

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY st.id DESC LIMIT " . $start . ", " . $end;

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function getDeletedInquiries($data)
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $query = "SELECT st.*, courses.course AS course_name, centers.center AS center_name, st.updated_by AS deleted_by, st.updated_date AS deleted_at FROM students AS st
            LEFT JOIN centers ON st.center = centers.id
            LEFT JOIN courses ON st.course = courses.id
            WHERE del_sts = 1 AND status = 0";

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY st.id DESC LIMIT " . $start . ", " . $end;

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function recentInquerys($data)
    {
        $start = $data['start'] ?? 0;
        $end = $data['end'] ?? 10;
        $search = $data['search'] ?? '';

        $query = "SELECT st.*, courses.course AS course_name, courses.type AS course_type, centers.center AS center_name FROM students AS st
            LEFT JOIN centers ON st.center = centers.id
            LEFT JOIN courses ON st.course = courses.id
            WHERE status = 0 AND del_sts = 0 AND st.add_date >= DATE_SUB(NOW(), INTERVAL 7 DAY) ";

        if (!empty($search)) {
            $query .= " AND (st.name LIKE '%" . $this->db->escapeLikeString($search) . "%' OR st.pnumber LIKE '%" . $this->db->escapeLikeString($search) . "%')";
        }

        $result['recordsTotal'] = $result['recordsFiltered'] = $this->db->query($query)->getNumRows();

        $query .= " ORDER BY st.id DESC LIMIT " . (int)$start . ", " . (int)$end;

        $result['data'] = $this->db->query($query)->getResultArray();
        return $result;
    }

    public function getStudentCount($data)
    {   
        $where = '';
        if($data['center_id']){
            $where .= " AND center = '". $data['center_id'] ."'";
        }

        $AdmiQuery = "SELECT COUNT(*) as AdmiCount FROM students
                        WHERE status = 1 AND del_sts = 0".$where." AND DATE_FORMAT(add_date, '%Y-%m') = '". $data['f_date'] ."'";
        $AdmiCount = $this->db->query($AdmiQuery)->getRowArray();

        $InqQuery = "SELECT COUNT(*) as InqCount FROM students
                        WHERE status = 0 AND del_sts = 0".$where." AND DATE_FORMAT(add_date, '%Y-%m') = '". $data['f_date'] ."'";
        $InqCount = $this->db->query($InqQuery)->getRowArray();

        $result['AdmiCount'] = $AdmiCount['AdmiCount'];
        $result['InqCount'] = $InqCount['InqCount'];
        return $result;   
    }
}
