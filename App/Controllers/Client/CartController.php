<?php

namespace App\Controllers\Client;

use App\Helpers\AuthHelper;
use App\Helpers\NotificationHelper;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Views\Client\Pages\Cart\Checkout;
use App\Views\Client\Pages\Cart\Index;
use App\Views\Client\Pages\Cart\ListOrder;
use App\Views\Client\Pages\Cart\Show;

class CartController
{
    // hiển thị danh sách
    public static function index()
    {
        ob_start(); // Bắt đầu buffer để ngăn các đầu ra không mong muốn

        // echo "<pre>";
        // var_dump($_COOKIE['cart']);
        if (isset($_COOKIE['cart'])) {
            $product = new Product();

            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);

            // // echo "<pre>";
            // echo "<pre>";
            // var_dump($cart_data);
            if (count($cart_data)) {
                foreach ($cart_data as $key => $value) {
                    $product_id = $value['product_id'];
                    // var_dump($product_id);
                    $result = $product->getOneProduct($product_id);
                    // var_dump($result);
                    $cart_data[$key]['data'] = $result;

                    // var_dump($cart_data);


                }

                // echo "<pre>"; 
                Header::render();
                Notification::render();
                NotificationHelper::unset();
                Index::render($cart_data);
                Footer::render();
            } else {
                // setcookie("cart", "", time() -  3600 * 24 * 30 * 12, '/');
                // $_SESSION['error'] = 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào';
                NotificationHelper::error('cart', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào');

                header('location: /products');
            }
        } else {
            // $_SESSION['error'] = 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào';
            NotificationHelper::error('cart', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào');

            header('location: /products');
            // var_dump($_SESSION['error']);
        }
        ob_end_flush();

    }

    public static function add()
    {
        ob_start(); // Bắt đầu buffer để ngăn các đầu ra không mong muốn

        $product = new Product();
        Header::render();
        Footer::render();

        $product_id = $_POST['id'];

        if (isset($_COOKIE['cart'])) {
            // nếu đã tồn tại cookie cart thì lấy giá trị của cookie cart 
            // nếu đã tồn tại cookie cart thì lấy giá trị của cookie cart 
            $cookie_data = $_COOKIE['cart'];

            // chuyển string thành array 
            $cart_data = json_decode($cookie_data, true);
        } else {
            $cart_data = [];
        }

        $product_id_arr = array_column($cart_data, 'product_id');

        // echo "<pre>";
        // var_dump($product_id_arr);
        // kiểm tra product_id có tồn tại trong cookie cart chưa 
        if (in_array($product_id, $product_id_arr)) {
            foreach ($cart_data as $key => $value) {
                // nếu có thì tăng có lượng sản phẩm 
                if ($cart_data[$key]['product_id'] == $product_id) {
                    $cart_data[$key]['quantity'] = $cart_data[$key]['quantity'] + 1;
                }
            }
        } else {
            // nếu chưa có thì thêm vào cookie cart 
            $product_array = [
                'product_id' => $product_id,
                'quantity' => 1,
            ];
            $cart_data[] = $product_array;
        }

        // chuyển array thành string để lưu vào cookie cart 
        $product_data = json_encode($cart_data);

        // lưu cookie 
        setcookie('cart', $product_data, time() + 3600 * 24 * 30 * 12, '/');

        NotificationHelper::success('cart', 'Đã thêm sản phẩm vào giỏ hàng');
        // sau khi lưu cookie thì phải chuyển trang/ load lại thì mới ăn cookie
        header('location: /cart');
        // if ($results->num_rows) {

        //     $products = $results->fetch_all(MYSQLI_ASSOC);
        //     include './src/views/client/chithl-cart/list-products.php';
        // } else {
        //     echo 'Trong';
        // }
        ob_end_flush();

    }

    public static function update()
    {
        ob_start(); // Bắt đầu buffer để ngăn các đầu ra không mong muốn

        $product_id = $_POST['id'];
        $quantity = $_POST['quantity'];

        if (isset($_COOKIE['cart'])) {
            // nếu đã tồn tại cookie cart thì lấy giá trị của cookie cart 
            // nếu đã tồn tại cookie cart thì lấy giá trị của cookie cart 
            $cookie_data = $_COOKIE['cart'];

            // chuyển string thành array 
            $cart_data = json_decode($cookie_data, true);
        } else {
            $cart_data = array();
        }

        $product_id_arr = array_column($cart_data, 'product_id');

        // kiểm tra product_id có tồn tại trong cookie cart chưa 
        if (in_array($product_id, $product_id_arr)) {
            foreach ($cart_data as $key => $value) {
                // nếu có thì cập nhật số lượng = số lượng mà ng dùng submit
                if ($cart_data[$key]['product_id'] == $product_id) {
                    $cart_data[$key]['quantity'] = $quantity;
                }
            }
        } else {
            // nếu chưa có thì thêm vào cookie cart 
            $product_array = array(
                'product_id' => $product_id,
                'quantity' => 1,
            );
            $cart_data[] = $product_array;
        }

        // chuyển array thành string để lưu vào cookie cart 
        $product_data = json_encode($cart_data);

        // lưu cookie 
        setcookie('cart', $product_data, time() + 3600 * 24 * 30 * 12, '/');

        NotificationHelper::success('cart', 'Đã cập nhật số lượng sản phẩm');

        // sau khi lưu cookie thì phải chuyển trang/ load lại thì mới ăn cookie
        header('location: /cart');
        ob_end_flush();

    }

    public static function deleteAll()
    {
        ob_start(); // Bắt đầu buffer để ngăn các đầu ra không mong muốn

        if (isset($_COOKIE['cart'])) {
            setcookie("cart", "", time() - 3600 * 24 * 30 * 12, '/');
        }
        NotificationHelper::success('cart', 'Đã xoá giỏ hàng');

        header('location: /products');
        ob_end_flush();

    }

    public static function deleteItem()

    {
        ob_start(); // Bắt đầu buffer để ngăn các đầu ra không mong muốn

        if (isset($_COOKIE['cart'])) {
            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);
            foreach ($cart_data as $key => $value) {
                if ($cart_data[$key]['product_id'] == $_POST['id']) {
                    unset($cart_data[$key]);
                    $product_data = json_encode($cart_data);

                    setcookie("cart", $product_data, time() + 3600 * 24 * 30 * 12, '/');
                }
            }
            NotificationHelper::success('cart', 'Đã xoá sản phẩm khỏi giỏ hàng');

            header('location: /cart');
        }
        ob_end_flush();

    }

    public static function checkout()
    {
        ob_start(); // Bắt đầu buffer để ngăn các đầu ra không mong muốn

        $is_login = AuthHelper::checkLogin();
        if (isset($_COOKIE['cart']) && $is_login) {

            $product = new Product();

            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);

            // // echo "<pre>";
            // echo "<pre>";
            // var_dump($cart_data);
            if (count($cart_data)) {
                foreach ($cart_data as $key => $value) {
                    $product_id = $value['product_id'];
                    // var_dump($product_id);
                    $result = $product->getOneProduct($product_id);
                    // var_dump($result);
                    $cart_data[$key]['data'] = $result;

                    // var_dump($cart_data);
                }

                // echo "<pre>"; 
                Header::render();
                Notification::render();
                NotificationHelper::unset();
                Checkout::render($cart_data);
                Footer::render();
            } else {
                // setcookie("cart", "", time() -  3600 * 24 * 30 * 12, '/');
                // $_SESSION['error'] = 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào';
                NotificationHelper::error('cart', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào');

                header('location: /products');
            }


        } else {
            NotificationHelper::error('checkout', 'Vui lòng đăng nhập hoặc thêm sản phẩm vào giỏ hàng để thanh toán');

            header('location: /');
        }
        ob_end_flush();


    }

    public static function createOrder()
    {
        ob_start(); // Bắt đầu buffer để ngăn các đầu ra không mong muốn
//        echo "<pre>";
//        print_r($_GET);
//         echo "<pre>";
//         die();
        $is_login = AuthHelper::checkLogin();
        if (isset($_COOKIE['cart']) && $is_login) {
            $product = new Product();
            $orderModel = new Order();

            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);

            if (count($cart_data)) {

                $order_id = $orderModel->createOrder($_GET['name'], $_GET['phone'], 1, 0, 0, $_SESSION['user']['id'], $_GET['address'] ?? null);

                foreach ($cart_data as $key => $value) {
                    $product_id = $value['product_id'];
                    $quantity = $value['quantity'];
                    $product_info = $product->getOneProduct($product_id);
                    $product_price = $product_info['price'];

                    $orderModel->createOrderDetail($quantity, $product_price, $product_id, $order_id);
                }

                NotificationHelper::success('order', 'Đơn hàng của bạn đã được tạo thành công');
                setcookie('cart', '', time() - 3600, '/');

                header('location: /list-orders');
            } else {
                // Nếu giỏ hàng trống
                NotificationHelper::error('cart', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào');
                header('location: /products');
            }
        } else {
            // Nếu chưa đăng nhập
            NotificationHelper::error('checkout', 'Vui lòng đăng nhập để tạo đơn hàng');
            header('location: /login');
        }

        ob_end_flush();
    }


    public static function listOrder()
    {
        $orderModel = new Order();
        $orders = $orderModel->getAllOrdersByUserId($_SESSION['user']['id']);
//          echo "<pre>";
//        print_r($orders);
//         echo "<pre>";
//         die();
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        ListOrder::render($orders);
        Footer::render();
    }


    public static function show($id)
    {
        $order = new Order();
        $data['orderDetail'] = $order->getAllOrderDetailsByUserId($id);

        if ($data['orderDetail']) {
            Header::render();
            Notification::render();
            NotificationHelper::unset();
            Show::render($data['orderDetail']);
            Footer::render();
        } else {
            NotificationHelper::error('order', 'Không có chi tiết đơn hàng này');
            header('location: /list-orders');
        }
    }


}
