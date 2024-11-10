<?php

namespace App\Controllers\Client;

use App\Helpers\NotificationHelper;
use App\Models\Product;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Home;
use App\Views\Client\Blog;
use App\Views\Client\Layouts\Header;

class HomeController
{
    // hiển thị danh sách
    public static function index()
    { 
        $product = new Product();
        $data['products'] = $product->getAllProductByStatus();
        
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        Home::render($data);
        Footer::render();
    }

    public static function blogController()
    {
        $product = new Product();
        $data['products'] = $product->getAllProductByStatus();
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        Blog::render($data);
        Footer::render();
    }
}