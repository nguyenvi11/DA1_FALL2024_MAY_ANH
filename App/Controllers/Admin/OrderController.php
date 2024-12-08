<?php

namespace App\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Views\Admin\Components\Notification;
use App\Views\Admin\Layouts\Footer;
use App\Views\Admin\Layouts\Header;
use App\Views\Admin\Pages\Order\Edit;
use App\Views\Admin\Pages\Order\Index;
use App\Views\Admin\Pages\Order\Show;


class OrderController
{
    // Hiển thị danh sách sản phẩm và tìm kiếm
    public static function index()
    {
        // Kiểm tra nếu có tìm kiếm từ người dùng
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

        // Khởi tạo đối tượng model
        $order = new Order();
        $data = $order->searchOrdersWithUser($searchTerm);
//                   echo "<pre>";
//        print_r($data);
//         echo "<pre>";
//         die();
        // Nếu có tìm kiếm, gọi phương thức tìm kiếm sản phẩm
//         if ($searchTerm) {
//             $data = $order->searchOrdersWithUser($searchTerm);
//         } else {
//             // Nếu không tìm kiếm, lấy tất cả sản phẩm
//             $data = $order->getAllProductJoinCategory();
//         }

        // Render header, notification, footer và danh sách sản phẩm
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        Index::render($data, $searchTerm); // Gửi dữ liệu và từ khóa tìm kiếm
        Footer::render();
    }


    // hiển thị giao diện form thêm
  

    // xử lý chức năng thêm


    public static function show($id)
    {
        $order = new Order();
        $data['orderDetail'] = $order->getAllOrderDetailsByUserId($id);
//echo "<pre>";
//print_r($data);
//die();
        if ($data['orderDetail']) {
            Header::render();
            Notification::render();
            NotificationHelper::unset();
            Show::render($data['orderDetail']);
            Footer::render();
        } else {
            NotificationHelper::error('order', 'Không có chi tiết đơn hàng này');
            header('location: /admin/orders');
        }
    }


    // hiển thị giao diện form sửa
    public static function edit($id)
    {

        $order = new Order();
        $data['order'] = $order->getOneOrder($id);

        // var_dump($data);
        if ($data['order']) {
            Header::render();
            Notification::render();
            NotificationHelper::unset();
            // hiển thị form sửa
            Edit::render($data);
            Footer::render();
        } else {
            NotificationHelper::error('order', 'Không có sản phẩm này');
            header('location: /admin/orders');
        }
    }


    // xử lý chức năng sửa (cập nhật)
    public static function update($id)
    {
//        echo "<pre>";
//                print_r($_POST);
//                echo "<pre>";
//                die();
        $order = new Order();
        $data = [
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
        ];


        $result = $order->updateOrder($id, $data);

        if ($result) {
            NotificationHelper::success('order', 'Cập nhật thành công');
        } else {
            NotificationHelper::success('order', 'Cập nhật thất bại');
        }
        header('location: /admin/orders');
    }

    // thực hiện xoá
    public static function delete($id)
    {
        $order = new Product();
        $result = $order->deleteProduct($id);
        if ($result) {
            // echo 'Xoá thành công';
            NotificationHelper::success('product', 'Xoá thành công');
        } else {
            NotificationHelper::error('product', 'Xoá thất bại');
        }


        header('location: /admin/products');
    }

}