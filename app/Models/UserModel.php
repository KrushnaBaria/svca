<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
             'first_name',
             'last_name',
             'group',
             'active',
        ];
    }

    public function profile($id){
        $query = "SELECT * FROM urls AS ut 
            LEFT JOIN auth_groups_users AS gu ON ut.user_id = gu.user_id
            LEFT JOIN users AS u ON u.id = gu.user_id WHERE u.id =". $id;

            $result = $this->db->query($query)->getResultArray();
            return $result;
    }

    public function user_list(){
        $query = "SELECT u.id AS id, u.first_name AS first_name, u.last_name AS last_name, ai.secret AS email, gu.group AS user_group, ai.created_at AS register_on, ai.last_used_at AS last_login FROM users AS u 
            LEFT JOIN auth_groups_users AS gu ON gu.user_id = u.id
            LEFT JOIN auth_identities AS ai ON ai.user_id = u.id";

            $result = $this->db->query($query)->getResultArray();
            return $result;
    }

    public function get_user_details($id){
        $query = "SELECT u.id AS id, u.first_name AS first_name, u.last_name AS last_name, ai.secret AS email FROM users AS u
            LEFT JOIN auth_identities AS ai ON ai.user_id = u.id WHERE u.id =". $id;

        $result = $this->db->query($query)->getResultArray();
        return $result[0];
    }

    public function user_update(){
        $request = \Config\Services::request();

        $id    = $request->getPost('uid');
        $fname = $request->getPost('first_name');
        $lname = $request->getPost('last_name');

        $query = "UPDATE users SET first_name = '". $fname ."', last_name = '". $lname ."' WHERE id =".$id;
        $result = $this->db->query($query);

        if($result){
            return 1;
        }
    }

    public function first_visit($id){
        $query = "SELECT * FROM `auth_groups_users` AS agu LEFT JOIN auth_logins AS al ON al.user_id = agu.user_id WHERE al.success = 1 AND agu.user_id = '". $id ."' ";
        $result = $this->db->query($query)->getNumRows();
        if($result > 1){
            return 0 ;
        }else{
            return 1 ;
        }
    }
}
