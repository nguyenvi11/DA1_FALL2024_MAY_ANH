<?php

namespace App\Views\Admin\Pages\Order;

use App\Views\BaseView;

class Index extends BaseView
{
    public static function render($data = null, $searchTerm = '')
    {
        ?>

        <?php
        $statusMap = [
            0 => ['label' => 'Chờ xử lí', 'class' => 'bg-primary'],
            1 => ['label' => 'Đang xử lý', 'class' => 'bg-warning'],
            2 => ['label' => 'Đang giao', 'class' => 'bg-info'],
            3 => ['label' => 'Đã giao', 'class' => 'bg-success'],
            4 => ['label' => 'Đã hủy', 'class' => 'bg-danger'],
        ];
        ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Quản lý đơn hàng</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh sách đơn hàng</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Danh sách đơn hàng</h5>

                                <!-- Form tìm kiếm -->
                                <form action="" method="GET" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                               placeholder="Tìm kiếm đơn hàng..."
                                               value="<?= htmlspecialchars($searchTerm) ?>">
                                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                </form>

                                <?php if (count($data)) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên KH</th>
                                                <th>SĐT</th>
                                                <th>Thanh toán</th>
                                                <th>Trạng thái thanh toán</th>
                                                <th>Trạng thái đơn hàng</th>
                                                <th>Người dùng</th>
                                                <th>Email</th>
                                                <th>Địa chỉ</th>
                                                <th>Hành động</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($data as $item) : ?>
<!--                                                            --><?php
//                                                                   echo "<pre>";
//        print_r($item['status']);
//         echo "<pre>";
//         die();
//// ?>
                                                <tr>
                                                    <td><?= $item['id'] ?></td>
                                                    <td><?= $item['name'] ?></td>
                                                    <td><?= $item['phone'] ?></td>
                                                    <td><?= $item['payments'] ?></td>
                                                    <td>
                                                        <span class="badge <?= $item['payment_status'] == 1 ? 'bg-success' : 'bg-warning' ?>">
                                                            <?= $item['payment_status'] == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if (isset($statusMap[$item['status']])) : ?>
                                                            <span class="badge <?= $statusMap[$item['status']]['class'] ?>">
                                                                <?= $statusMap[$item['status']]['label'] ?>
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="badge bg-secondary">Không xác định</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td><?= $item['user_name'] ?></td>
                                                    <td><?= $item['user_email'] ?></td>
                                                    <td><?= $item['address'] ?></td>
                                                    <td>
                                                        <a href="/admin/orders/<?= $item['id'] ?>"
                                                           class="btn btn-info btn-sm">Chi tiết</a>
                                                        <a href="/admin/orders/edit/<?= $item['id'] ?>"
                                                           class="btn btn-primary btn-sm">Chỉnh sửa</a>
<!--                                                        <form action="/admin/orders/--><?php //= $item['id'] ?><!--" method="POST"-->
<!--                                                              style="display:inline;"-->
<!--                                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">-->
<!--                                                            <input type="hidden" name="_method" value="DELETE">-->
<!--                                                            <button type="submit" class="btn btn-danger btn-sm">Xóa-->
<!--                                                            </button>-->
<!--                                                        </form>-->
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <h4 class="text-center text-danger">Không có dữ liệu</h4>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
