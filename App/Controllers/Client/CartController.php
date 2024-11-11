<?php

namespace App\Controllers\Client;

use App\Helpers\AuthHelper;
use App\Helpers\NotificationHelper;
use App\Models\Product;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Views\Client\Pages\Cart\Checkout;
use App\Views\Client\Pages\Cart\Index;

class CartController
{
    // hiển thị danh sách
    public static function index()
    {
        if (isset($_COOKIE['cart'])) {
            $product = new Product();
            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);

            if (count($cart_data)) {
                foreach ($cart_data as $key => $value) {
                    $product_id = $value['product_id'];
                    $result = $product->getOneProduct($product_id);
                    $cart_data[$key]['data'] = $result;
                }

                Header::render();
                Notification::render();
                NotificationHelper::unset();
                Index::render($cart_data);
                Footer::render();
            } else {
                NotificationHelper::error('cart', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào');
                header('Location: /products');
                exit;
            }
        } else {
            NotificationHelper::error('cart', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào');
            header('Location: /products');
            exit;
        }
    }

    public static function add()
    {
        $product = new Product();
        $product_id = $_POST['id'];

        if (isset($_COOKIE['cart'])) {
            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);
        } else {
            $cart_data = [];
        }

        $product_id_arr = array_column($cart_data, 'product_id');

        if (in_array($product_id, $product_id_arr)) {
            foreach ($cart_data as $key => $value) {
                if ($cart_data[$key]['product_id'] == $product_id) {
                    $cart_data[$key]['quantity'] += 1;
                }
            }
        } else {
            $cart_data[] = ['product_id' => $product_id, 'quantity' => 1];
        }

        setcookie('cart', json_encode($cart_data), time() + 3600 * 24 * 30 * 12, '/');
        NotificationHelper::success('cart', 'Đã thêm sản phẩm vào giỏ hàng');
        header('Location: /cart');
        exit;
    }

    public static function update()
    {
        $product_id = $_POST['id'];
        $quantity = $_POST['quantity'];

        if (isset($_COOKIE['cart'])) {
            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);
        } else {
            $cart_data = [];
        }

        $product_id_arr = array_column($cart_data, 'product_id');

        if (in_array($product_id, $product_id_arr)) {
            foreach ($cart_data as $key => $value) {
                if ($cart_data[$key]['product_id'] == $product_id) {
                    $cart_data[$key]['quantity'] = $quantity;
                }
            }
        }

        setcookie('cart', json_encode($cart_data), time() + 3600 * 24 * 30 * 12, '/');
        NotificationHelper::success('cart', 'Đã cập nhật số lượng sản phẩm');
        header('Location: /cart');
        exit;
    }

    public static function deleteAll()
    {
        if (isset($_COOKIE['cart'])) {
            setcookie("cart", "", time() - 3600 * 24 * 30 * 12, '/');
        }
        NotificationHelper::success('cart', 'Đã xoá giỏ hàng');
        header('Location: /products');
        exit;
    }

    public static function deleteItem()
    {
        if (isset($_COOKIE['cart'])) {
            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);

            foreach ($cart_data as $key => $value) {
                if ($cart_data[$key]['product_id'] == $_POST['id']) {
                    unset($cart_data[$key]);
                    $cart_data = array_values($cart_data); // Đánh lại chỉ mục mảng sau khi xóa
                    setcookie("cart", json_encode($cart_data), time() + 3600 * 24 * 30 * 12, '/');
                    break;
                }
            }

            NotificationHelper::success('cart', 'Đã xoá sản phẩm khỏi giỏ hàng');
            header('Location: /cart');
            exit;
        }
    }

    public static function checkout()
    {
        $is_login = AuthHelper::checkLogin();

        if (isset($_COOKIE['cart']) && $is_login) {
            $product = new Product();
            $cookie_data = $_COOKIE['cart'];
            $cart_data = json_decode($cookie_data, true);

            if (count($cart_data)) {
                foreach ($cart_data as $key => $value) {
                    $product_id = $value['product_id'];
                    $result = $product->getOneProduct($product_id);
                    $cart_data[$key]['data'] = $result;
                }

                Header::render();
                Notification::render();
                NotificationHelper::unset();
                Checkout::render($cart_data);
                Footer::render();
            } else {
                NotificationHelper::error('cart', 'Giỏ hàng trống. Vui lòng thêm sản phẩm vào');
                header('Location: /products');
                exit;
            }
        } else {
            NotificationHelper::error('checkout', 'Vui lòng đăng nhập hoặc thêm sản phẩm vào giỏ hàng để thanh toán');
            header('Location: /');
            exit;
        }
    }
}
