<?php

namespace App\Views\Admin\Pages\Order;

use App\Views\BaseView;

class Show extends BaseView
{
    public static function render($data = null)
    {
        ?>

        <!-- Page wrapper -->
        <div class="page-wrapper">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Chi tiết đơn hàng</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container fluid -->
            <div class="container-fluid">
                <!-- Page content -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Thông tin đơn hàng</h5>

                                <!-- Product details table -->
                                <table class="table table-bordered table-striped">
                                    <thead class="table-info">
                                    <tr>
                                        <th>#</th>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Tổng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($data as $index => $orderDetail): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <img src="<?= APP_URL ?>/public/uploads/products/<?= $orderDetail['product']['image'] ?>"
                                                     alt="<?= $orderDetail['product']['name'] ?>"
                                                     class="img-fluid img-thumbnail" style="max-width: 120px;">
                                                <p><strong><?= $orderDetail['product']['name'] ?></strong></p>
                                            </td>
                                            <td><?= $orderDetail['quantity'] ?></td>
                                            <td><?= number_format($orderDetail['order_detail_price'], 0, ',', '.') ?> VND</td>
                                            <td><?= number_format($orderDetail['quantity'] * $orderDetail['order_detail_price'], 0, ',', '.') ?> VND</td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <!-- Total price -->
                                <div class="d-flex justify-content-end">
                                    <h5 class="text-end">
                                        <strong>Tổng cộng: </strong>
                                        <?php
                                        $total = 0;
                                        foreach ($data as $orderDetail) {
                                            $total += $orderDetail['quantity'] * $orderDetail['order_detail_price'];
                                        }
                                        echo number_format($total, 0, ',', '.') . ' VND';
                                        ?>
                                    </h5>
                                </div>

                                <!-- Return button -->
                                <div class="border-top mt-3">
                                    <div class="card-body text-end">
                                        <a href="/admin/orders" class="btn btn-secondary">Quay lại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}
?>
