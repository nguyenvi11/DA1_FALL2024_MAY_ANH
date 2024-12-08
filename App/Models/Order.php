<?php

namespace App\Models;

use Exception;

class Order extends BaseModel
{
    protected $table = 'orders';
    protected $id = 'id';

    public function updateOrder($id, $data)
    {
        return $this->update($id, $data);
    }

    public function getOneOrder($id)
    {
        return $this->getOne($id);
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

    public function searchOrdersWithUser($searchTerm = null, $paymentStatus = null, $orderStatus = null)
    {
        // Câu truy vấn cơ bản
        $sql = "SELECT 
                orders.id,
                orders.name,
                orders.phone,
                orders.payments,
                orders.payment_status,
                orders.status,
                orders.user_id,
                orders.address,
                users.name AS user_name,
                users.email AS user_email
            FROM orders
            INNER JOIN users ON orders.user_id = users.id
            WHERE 1=1";

        // Thêm điều kiện nếu có
        if ($searchTerm) {
            $sql .= " AND (orders.name LIKE ? OR users.name LIKE ? OR users.phone LIKE ?)";
        }
        if (!is_null($paymentStatus)) {
            $sql .= " AND orders.payment_status = ?";
        }
        if (!is_null($orderStatus)) {
            $sql .= " AND orders.status = ?";
        }

        $sql .= " ORDER BY orders.id DESC";

        $conn = $this->_conn->MySQLi(); // Kết nối DB
        $stmt = $conn->prepare($sql); // Chuẩn bị câu lệnh

        // Bind các tham số vào câu lệnh SQL
        $bindTypes = ''; // Loại dữ liệu cho bind_param
        $bindParams = []; // Mảng tham số

        if ($searchTerm) {
            $searchTermLike = '%' . $searchTerm . '%';
            $bindTypes .= 'sss'; // Ba tham số dạng chuỗi
            $bindParams[] = $searchTermLike;
            $bindParams[] = $searchTermLike;
            $bindParams[] = $searchTermLike;
        }
        if (!is_null($paymentStatus)) {
            $bindTypes .= 'i'; // Số nguyên
            $bindParams[] = $paymentStatus;
        }
        if (!is_null($orderStatus)) {
            $bindTypes .= 'i'; // Số nguyên
            $bindParams[] = $orderStatus;
        }

        if ($bindTypes) {
            $stmt->bind_param($bindTypes, ...$bindParams); // Gắn các tham số
        }

        $stmt->execute(); // Thực thi câu lệnh
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Trả về kết quả
    }



    public function getAllOrderDetailsByUserId($orderId)
    {

        $orderDetails = [];
        try {
            $sql = "
        SELECT 
            od.id AS order_detail_id,
            od.quantity,
            od.price AS order_detail_price,
            p.id AS product_id,
            p.name AS product_name,
            p.image AS product_image,
            p.description AS product_description,
            p.price AS product_price,
            p.discount_price AS product_discount_price,
            p.date AS product_date,
            p.is_featured AS product_is_featured,
            p.view AS product_view,
            p.status AS product_status,
            o.id AS order_id,
            o.name AS order_name,
            o.phone AS order_phone,
            o.payments AS order_payments,
            o.payment_status AS order_payment_status,
            o.status AS order_status,
            o.user_id AS order_user_id,
            o.address AS order_address
        FROM 
            order_details od
        JOIN 
            products p ON od.product_id = p.id
        JOIN 
            orders o ON od.order_id = o.id
        WHERE 
            od.order_id = ?
        ";

            $conn = $this->_conn->MySQLi();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $orderId);
            $stmt->execute();

            // Lấy tất cả kết quả trả về
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $orderDetails[] = [
                    'order_detail_id' => $row['order_detail_id'],
                    'quantity' => $row['quantity'],
                    'order_detail_price' => $row['order_detail_price'],
                    'product' => [
                        'id' => $row['product_id'],
                        'name' => $row['product_name'],
                        'image' => $row['product_image'],
                        'description' => $row['product_description'],
                        'price' => $row['product_price'],
                        'discount_price' => $row['product_discount_price'],
                        'date' => $row['product_date'],
                        'is_featured' => $row['product_is_featured'],
                        'view' => $row['product_view'],
                        'status' => $row['product_status'],
                    ],
                    'order' => [
                        'id' => $row['order_id'],
                        'name' => $row['order_name'],
                        'phone' => $row['order_phone'],
                        'payments' => $row['order_payments'],
                        'payment_status' => $row['order_payment_status'],
                        'status' => $row['order_status'],
                        'user_id' => $row['order_user_id'],
                        'address' => $row['order_address'],
                    ]
                ];
            }
        } catch (\Throwable $th) {
            error_log('Lỗi khi lấy chi tiết đơn hàng của user: ' . $th->getMessage());
        }

        return $orderDetails;
    }


}