<?php

namespace App\Models;

class User extends BaseModel
{
    protected $table = 'users';
    protected $id = 'id';

    public function getAllUser()
    {
        return $this->getAll();
    }
    public function getOneUser($id)
    {
        return $this->getOne($id);
    }

    public function createUser($data)
    {
        return $this->create($data);
    }
    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    public function getAllUserByStatus()
    {
        return $this->getAllByStatus();
    }

    public function login($username)
    {
        $sql = "SELECT * FROM $this->table WHERE username=? LIMIT 1";
        $conn = $this->_conn->MySQLi();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('s', $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function getOneUserByUsernameOrEmail($username, $email)
    {
        $sql = "SELECT * FROM $this->table WHERE username=? OR email=? LIMIT 1";
        $conn = $this->_conn->MySQLi();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getOneUserByUsername(string $username){
        $result = [];
        try {
            $sql = "SELECT * FROM users WHERE username=?";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);

            $stmt->bind_param('s', $username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
    } catch(\Throwable $th) {
        error_log('Lỗi hiện thị chi tiết dữ liệu bằng username: '. $th->getMessage());
        return $result;
    }
}

public function updateUserByUsernameAndEmail(array $data)
    {

        try {
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $sql = "UPDATE $this->table SET password='$password' WHERE username='$username' AND email='$email' ";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);
            return $stmt->execute();
            } catch (\Throwable $th) {
            error_log('Lỗi khi cập nhật dữ liệu: ', $th->getMessage());
            return false;
        }
    }
    public function countTotalUser(){
        return $this->countTotal();
    }
}