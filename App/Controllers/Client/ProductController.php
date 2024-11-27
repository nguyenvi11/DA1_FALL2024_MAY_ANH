<?php

namespace App\Controllers\Client;

use App\Helpers\AuthHelper;
use App\Helpers\NotificationHelper;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Views\Client\Pages\Product\Category as ProductCategory;
use App\Views\Client\Pages\Product\Detail;
use App\Views\Client\Pages\Product\Index;

class ProductController
{
    // hiển thị danh sách
    public static function index()
    {
        $product = new Product();
    
        // Lấy các tham số sort_by và order từ GET request
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name'; // Mặc định là sắp xếp theo tên
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // Mặc định là tăng dần
    
        // Lấy tất cả sản phẩm đã kích hoạt và sắp xếp theo các tiêu chí
        $data['products'] = $product->getAllProductByStatusAndSort($sort_by, $order);
    
        // Lấy danh sách các danh mục
        $category = new Category();
        $data['categories'] = $category->getAllCategoryByStatus();
    
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        Index::render($data);
        Footer::render();
    }
    

    // Tìm kiếm sản phẩm
    public static function search()
    {
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $query = $_GET['query'];
            $product = new Product();
            $data['products'] = $product->searchProductByName($query);

            $category = new Category();
            $data['categories'] = $category->getAllCategoryByStatus();

            Header::render();
            Notification::render();
            NotificationHelper::unset();
            Index::render($data);
            Footer::render();
        } else {
            // Nếu không có query thì hiển thị tất cả sản phẩm
            self::index();
        }
    }

    public static function detail($id)
    {
        $product = new Product();
        $data['product'] = $product->getOneProductByStatus($id);
        $comment = new Comment();
        $data['comments'] = $comment->get5CommentNewestByProductAndStatus($id);
        $data['is_login'] = AuthHelper::checkLogin();

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        Detail::render($data);
        Footer::render();
    }
    public static function getProductByCategory($id)
    {
        $product = new Product();
        $data['products'] = $product->getAllProductByCategoryAndStatus($id);
        // $test = $product->getAllProductByCategoryAndStatus($id);
        // var_dump($test);
        $category = new Category();
        $data['categories'] = $category->getAllCategoryByStatus();
        // var_dump($data);
        Header::render();
        ProductCategory::render($data);
        Footer::render();
    }
}