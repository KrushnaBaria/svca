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

    public function user_list(){
        $query = "SELECT u.id AS id, u.first_name AS first_name, u.last_name AS last_name, ai.secret AS email, gu.group AS user_group, ai.created_at AS register_on, ai.last_used_at AS last_login FROM users AS u 
            LEFT JOIN auth_groups_users AS gu ON gu.user_id = u.id
            LEFT JOIN auth_identities AS ai ON ai.user_id = u.id";

            $result = $this->db->query($query)->getResultArray();
            return $result;
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
}
