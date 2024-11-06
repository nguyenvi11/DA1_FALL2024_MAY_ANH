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
        $data['products'] = $product->getAllProductByStatus();

        $category = new Category();
        $data['categories'] = $category->getAllCategoryByStatus();
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        Index::render($data);
        Footer::render();
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
