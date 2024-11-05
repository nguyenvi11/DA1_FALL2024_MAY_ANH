<?php

namespace App\Models;

use App\Helpers\NotificationHelper;
use App\Interfaces\CrudInterface;
use Exception;

abstract class BaseModel implements CrudInterface
{
    protected $_conn;

    protected $table;
    protected $id;

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;


    public function __construct()
    {
        $this->_conn = new Database();
    }

    public function getAll()
    {
        $result = [];
        try {
            $sql = "SELECT * FROM $this->table";
            $result = $this->_conn->MySQLi()->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $th) {
            error_log('Lỗi khi hiển thị tất cả dữ liệu: ' . $th->getMessage());
            NotificationHelper::error('getAll', 'Lỗi khi hiển thị tất cả dữ liệu');
            return $result;
        }
    }
    public function getOne(int $id)
    {
        $result = [];
        try {
            $sql = "SELECT * FROM $this->table WHERE $this->id=?";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);

            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (\Throwable $th) {
            error_log('Lỗi khi hiển thị chi tiết dữ liệu: ' . $th->getMessage());
            NotificationHelper::error('getOne', 'Lỗi khi hiển thị chi tiết dữ liệu');
            return $result;
        }
    }
    public function create(array $data)
    {
        // $sql ="INSERT INTO $this->table (name, description, status) VALUES ('category test', 'category test description', '1')";

        // $result = $this->_conn->connect()->query($sql);
        // return $result;

        try {
            $sql = "INSERT INTO $this->table (";
            foreach ($data as $key => $value) {
                $sql .= "$key, ";
            }
            // INSERT INTO $this->table (name, description, status, 
            $sql = rtrim($sql, ", ");
            // INSERT INTO $this->table (name, description, status
            $sql .=   " ) VALUES (";
            // INSERT INTO $this->table (name, description, status) VALUES (
            foreach ($data as $key => $value) {
                $sql .= "'$value', ";
            }

            // INSERT INTO $this->table (name, description, status) VALUES ('category test', 'category test description', '1', 
            $sql = rtrim($sql, ", ");
            // INSERT INTO $this->table (name, description, status) VALUES ('category test', 'category test description', '1'

            $sql .= ")";
            // INSERT INTO $this->table (name, description, status) VALUES ('category test', 'category test description', '1')

            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);

            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log('Lỗi khi thêm dữ liệu: ' . $th->getMessage());
            NotificationHelper::error('create', 'Lỗi khi thêm dữ liệu');
            return false;
        }
    }
    public function update(int $id, array $data)
    {
        try {
            $sql = "UPDATE $this->table SET ";
            foreach ($data as $key => $value) {
                $sql .= "$key = '$value', ";
            }
            $sql = rtrim($sql, ", ");

            $sql .= " WHERE $this->id=$id";

            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log('Lỗi khi cập nhật dữ liệu: ', $th->getMessage());
            NotificationHelper::error('update', 'Lỗi khi cập nhật dữ liệu');
            return false;
        }
    }
    public function delete(int $id): bool
    {
        try {
            $sql = "DELETE FROM $this->table WHERE $this->id=$id";

            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);
            $stmt->execute();


            // if (!$stmt->execute()) {
            //     throw new Exception("Lỗi khi xóa dữ liệu từ bảng phụ: " . $stmt->error); // quăng ra lỗi
            // }

            // trả về số hàng dữ liệu bị ảnh hưởng
            return $stmt->affected_rows;
        } catch (\Throwable $th) {
            //throw $th;
            // $message = "Lỗi khi xóa dữ liệu: " . $e->getMessage(); //bắt lỗi và bắt messages lỗi
            error_log('Lỗi khi xóa dữ liệu: ' . $th->getMessage());
            NotificationHelper::error('delete', 'Lỗi khi xóa dữ liệu');
            return false;
        }
    }

    public function getAllByStatus()
    {
        $sql = "SELECT * FROM $this->table WHERE status=" . self::STATUS_ENABLE;
        $result = $this->_conn->MySQLi()->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOneByStatus(int $id)
    {
        $sql = "SELECT * FROM $this->table WHERE $this->id=? AND status=" . self::STATUS_ENABLE;
        $conn = $this->_conn->MySQLi();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getAllProductJoinCategory()
    {
        $sql = "SELECT products.*, categories.name AS category_name FROM products INNER JOIN categories ON products.category_id = categories.id";
        $result = $this->_conn->MySQLi()->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getAllProductByCategoryAndStatus($id)
    {
        $sql = "SELECT products.*, categories.name AS category_name 
            FROM products INNER JOIN categories ON products.category_id = categories.id 
            WHERE products.category_id=? AND products.status=1 AND categories.status=1";
        $conn = $this->_conn->MySQLi();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function getOneByName(string $name)
    {
        $result = [];
        try {
            $sql = "SELECT * FROM $this->table WHERE name=? LIMIT 1";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);

            $stmt->bind_param('s', $name);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (\Throwable $th) {
            error_log('Lỗi khi hiển thị dữ liệu: ' . $th->getMessage());
            NotificationHelper::error('getOne', 'Lỗi khi hiển thị dữ liệu');
            return $result;
        }
    }
    public function countTotal()
    {
        $result = [];
        try {
            $sql = "SELECT COUNT(*) AS total FROM $this->table";
            $result = $this->_conn->MySQLi()->query($sql);
            return $result->fetch_assoc();
        } catch (\Throwable $th) {
            error_log('Lỗi khi count tất cả dữ liệu: ' . $th->getMessage());
            return $result;
        }
    }
    
   
}
