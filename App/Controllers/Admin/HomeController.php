<?php

namespace App\Controllers\Admin;
use App\Models\BaseModel;

use App\Helpers\NotificationHelper;
use App\Views\Admin\Components\Notification;
use App\Views\Admin\Home;
use App\Views\Admin\Layouts\Footer;
use App\Views\Admin\Layouts\Header;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;


class HomeController
{
    // hiển thị danh sách
    public static function index()
    {
        $user = new User();
        $total_user = $user->countTotalUser();

        $category = new Category();
        $total_category = $category->countTotalCategory();

        $product = new Product();
        $total_product = $product->countTotalProduct();
        $product_by_category=$product->countProductByCategory();

        $comment = new Comment();
        $total_comment = $comment->countTotalComment();
        $comment_by_product = $comment->countCommentByProduct();
        //  var_dump($product_by_category);

        $data = [
            'total_user' => $total_user['total'],
            'total_category' => $total_category['total'],
            'total_product' => $total_product['total'],
            'total_comment' => $total_comment['total'],
            'product_by_category'=>$product_by_category,
            'comment_by_product'=>$comment_by_product
        ];
        Header::render();
        Home::render($data);
        Footer::render();
    }
}
