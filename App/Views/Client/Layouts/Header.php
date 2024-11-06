<?php

namespace App\Views\Client\Layouts;

use App\Helpers\AuthHelper;
use App\Views\BaseView;

class Header extends BaseView
{
    public static function render($data = null)
    {
        $is_login = AuthHelper::checkLogin();
        // var_dump($is_login);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <title>Furni Free Bootstrap Template</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/assets/client/css/style.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/assets/client/css/bbootstrap.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/assets/client/css/tiny-slider.css">
    
    <style>
        /* Đặt thanh điều hướng trong suốt trên nền banner */
        .navbar.bg-transparent {
            background-color: rgba(0, 0, 0, 0.5) !important; /* Nền trong suốt */
        }

        .navbar .nav-link,
        .navbar .navbar-brand {
            color: #fff !important; /* Màu trắng cho văn bản */
        }
        
    </style>
</head>

<body>

    <!-- Start Header/Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../public/assets/client/images/logo_camera.png" height="70px" width="100px" alt="Logo">
                Camera<span>.</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Trang chủ <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/products">Sản phẩm</a>
                    </li>
                  
                
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
                </form>
                <ul class="navbar-nav ml-3">
                <li class="nav-item">
                        <a class="nav-link" href="/cart">Giỏ hàng</a>
                    </li>
                <?php if ($is_login) : ?>
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tài khoản
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="/users/<?= $_SESSION['user']['id'] ?>"><?= $_SESSION['user']['username'] ?></a>
                                    <a class="dropdown-item" href="/logout">Đăng xuất</a>
                                </div>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Đăng ký</a>
                        </li>
                    <?php endif; ?>
                   
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero section -->
    <div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Studio Bán <span class="d-block">Camera Hiện Đại</span></h1>
                    <p class="mb-4">Mang lại giá trị và hỗ trợ hiệu quả. Kết hợp các yếu tố linh hoạt với tính thẩm mỹ. Định hướng mục tiêu và tối ưu hóa trải nghiệm người dùng.</p>
                    <p><a href="" class="btn btn-secondary me-2">Mua Ngay</a><a href="#" class="btn btn-white-outline">Khám Phá</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

                <div class="col-lg-7">
                
                </div>
            </div>
        </div>
    </div>
<?php
    } // Kết thúc hàm render
}