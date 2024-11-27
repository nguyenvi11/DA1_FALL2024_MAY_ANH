<?php

namespace App\Models;

class Product extends BaseModel
{
    // private $_conn;

    protected $table = 'products';
    protected $id = 'id';
    // public function __construct()
    // {
    //     parent::__construct();
    //     // $this->_conn = new Database();
    // }
    public function getAllProduct()
    {
        return $this->getAll();
    }
    public function getOneProduct($id)
    {
        return $this->getOne($id);
    }

    public function createProduct($data)
    {
        return $this->create($data);
    }
    public function updateProduct($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->delete($id);
    }
    public function getAllProductByStatus()
    {
        return $this->getAllByStatus();
    }


    public function getAllProductJoinCategory()
    {
        // $this->_conn = new Database();

        $sql = "SELECT products.*, categories.name AS category_name 
                FROM products INNER JOIN categories ON products.category_id = categories.id";
        $result = $this->_conn->MySQLi()->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getAllProductByCategoryAndStatus($id)
    {
        // $this->_conn = new Database();


        $sql = "SELECT products.*, categories.name AS category_name 
            FROM products INNER JOIN categories ON products.category_id = categories.id 
            WHERE products.category_id=? AND products.status=" . self::STATUS_ENABLE .
            " AND categories.status=" . self::STATUS_ENABLE;
        $conn = $this->_conn->MySQLi();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOneProductByName($name)
    {
        return $this->getOneByName($name);
    }

    public function getOneProductByStatus(int $id)
    {
        $result = [];
        try {
            $sql = "SELECT products.*, categories.name AS category_name FROM products
INNER JOIN categories ON products.category_id=categories.id
WHERE products.status=" . self::STATUS_ENABLE . "
AND categories.status=" . self::STATUS_ENABLE . " AND products.id=?";
            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (\Throwable $th) {

            return $result;
        }
    }
    public function countTotalProduct()
    {
        return $this->countTotal();
    }
    public function countProductByCategory()
    {
        $result = [];
        try {
            $sql = "SELECT COUNT(*) AS count,categories.name FROM products INNER JOIN categories ON products.category_id=categories.id GROUP BY products.category_id";
            $result = $this->_conn->MySQLi()->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $th) {
            error_log('Lỗi khi hiển thị dữ liệu: ' . $th->getMessage());
            return $result;
        }
    }

    // Tìm sản phẩm theo tên
    public function searchProductByName($name)
    {
        $sql = "SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id
                    WHERE products.name LIKE ? AND products.status = 1
                    AND categories.status = 1";

        $conn = $this->_conn->MySQLi();
        $stmt = $conn->prepare($sql);

        $searchTerm = "%" . $name . "%";
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // public function getProductImages($productId)
    // {
    //     $sql = "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC";
    //     $stmt = $this->_conn->MySQLi()->prepare($sql);
    //     $stmt->bind_param('i', $productId);
    //     $stmt->execute();
    //     return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    // }

    public function getAllProductByStatusAndSort($sortBy = 'price', $order = 'asc')
    {
        // Sanitize inputs to prevent SQL injection
        $validSortColumns = ['price', 'name']; // Allowed sort columns
        $validOrderDirections = ['asc', 'desc']; // Allowed order directions

        // If the input is invalid, default to 'price' and 'asc'
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'price';
        }
        if (!in_array($order, $validOrderDirections)) {
            $order = 'asc';
        }

        // SQL query with dynamic sorting
        $sql = "SELECT * FROM products 
                WHERE status = 1 
                ORDER BY $sortBy $order";

        $conn = $this->_conn->MySQLi();
        $result = $conn->query($sql);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    
}