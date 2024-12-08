<?php

namespace App\Views\Admin\Pages\Order;

use App\Views\BaseView;

class Edit extends BaseView
{
    public static function render($data = null)
    {

?>


        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
<!--                --><?php //              echo "<pre>";
//                print_r($data);
//                echo "<pre>";
//                die(); ?>
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Chỉnh sửa đơn hàng</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Sửa đơn hàng</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form class="form-horizontal" action="/admin/orders/update/<?= $data['order']['id'] ?>" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <h4 class="card-title">Sửa đơn hàng</h4>
                                    <input type="hidden" name="method" id="" value="PUT">
                                    <div class="form-group">
                                        <label for="name">Tên khách hàng*</label>
                                        <input type="text" class="form-control" id="name" value="<?= $data['order']['name'] ?? '' ?>" placeholder="Nhập tên khách hàng..." name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại*</label>
                                        <input type="text" class="form-control" id="phone" value="<?= $data['order']['phone'] ?? '' ?>" placeholder="Nhập số điện thoại..." name="phone" required pattern="[0-9]{10}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Địa chỉ*</label>
                                        <textarea class="form-control" id="address" placeholder="Nhập địa chỉ khách hàng..." name="address" rows="3" required><?= $data['order']['address'] ?? '' ?></textarea>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
<!--                                        <button type="reset" class="btn btn-danger text-white" name="">Làm lại</button>-->
                                        <button type="submit" class="btn btn-primary" name="">Cập nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

    <?php
    }
}
