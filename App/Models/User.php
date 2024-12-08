<?php

namespace App\Models;

use Exception;

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


    public function getAllOrdersByUserId($userId)
    {
        $orders = [];
        try {
            // SQL truy vấn lấy tất cả đơn hàng của user
            $sql = "SELECT * FROM orders WHERE user_id = ?";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);

            // Gán giá trị $userId vào truy vấn
            $stmt->bind_param('i', $userId);
            $stmt->execute();

            // Lấy tất cả kết quả trả về
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        } catch (\Throwable $th) {
            error_log('Lỗi khi lấy danh sách đơn hàng của user: ' . $th->getMessage());
        }

        return $orders;
    }

    public function countTotalUser(){
        return $this->countTotal();
    }


    public function createOrder($name, $phone, $payments, $payment_status, $status, $user_id,$address)
    {
        try {
            // Câu lệnh SQL để thêm đơn hàng mới
            $sql = "INSERT INTO orders (name, phone, payments, payment_status, status, user_id,address) 
                    VALUES (?, ?, ?, ?, ?, ?,?)";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssiis', $name, $phone, $payments, $payment_status, $status, $user_id,$address);

            if ($stmt->execute()) {
                return $conn->insert_id; // Trả về ID của đơn hàng mới
            } else {
                throw new Exception("Lỗi khi tạo đơn hàng.");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Hàm tạo chi tiết đơn hàng
    public function createOrderDetail($quantity, $price, $product_id, $order_id)
    {
        try {
            // Câu lệnh SQL để thêm chi tiết đơn hàng
            $sql = "INSERT INTO order_details (quantity, price, product_id, order_id) 
                    VALUES (?, ?, ?, ?)";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('idii', $quantity, $price, $product_id, $order_id);

            if ($stmt->execute()) {
                return true; // Trả về true nếu thêm chi tiết đơn hàng thành công
            } else {
                throw new Exception("Lỗi khi tạo chi tiết đơn hàng.");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}