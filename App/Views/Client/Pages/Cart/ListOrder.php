<?php

namespace App\Views\Client\Pages\Cart;

use App\Helpers\AuthHelper;
use App\Views\BaseView;

class ListOrder extends BaseView
{
    public static function render($data = null)
    {
        $is_login = AuthHelper::checkLogin();

?>

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <div class="container mt-5" style="margin-bottom: 100px">
            <div class="d-flex justify-content-between mb-4">
                <h3>Danh Sách Đơn Hàng</h3>
<!--                <div>-->
<!--                    <button class="btn btn-primary">Tạo Người Dùng Mới</button>-->
<!--                    <button class="btn btn-success">Nhập</button>-->
<!--                    <button class="btn btn-info">Xuất</button>-->
<!--                </div>-->
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Số Điện Thoại</th>
                        <th>Địa chỉ</th>
                        <th>Thanh Toán</th>
                        <th>Trạng Thái Thanh Toán</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $index => $order) { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($order['name']); ?></td>
                            <td><?php echo htmlspecialchars($order['phone']); ?></td>
                            <td><?php echo ($order['address']); ?></td>
                            <td><?php echo $order['payments'] == 1 ? 'Đã Thanh Toán' : 'Chưa Thanh Toán'; ?></td>
                            <td><?php echo $order['payment_status'] == 1 ? 'Hoàn Thành' : 'Chưa Hoàn Thành'; ?></td>
                            <td><?php echo $order['status'] == 1 ? 'Đã Xử Lý' : 'Chưa Xử Lý'; ?></td>
                            <td>
                                <a href="/orders/<?= $order['id'] ?>"
                                   class="btn btn-info btn-sm">Chi tiết</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Xác Nhận Xóa -->
<!--            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--                <div class="modal-dialog" role="document">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
<!--                            <h5 class="modal-title" id="myModalLabel">Xác Nhận Xóa</h5>-->
<!--                        </div>-->
<!--                        <div class="modal-body">-->
<!--                            <p>Bạn có chắc chắn muốn xóa người dùng này?</p>-->
<!--                        </div>-->
<!--                        <div class="modal-footer">-->
<!--                            <button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Hủy</button>-->
<!--                            <button class="btn btn-danger" data-dismiss="modal">Xóa</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <!-- Pagination -->
<!--            <div class="d-flex justify-content-center mt-4">-->
<!--                <nav>-->
<!--                    <ul class="pagination">-->
<!--                        <li class="page-item"><a class="page-link" href="#">Trước</a></li>-->
<!--                        <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--                        <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                        <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                        <li class="page-item"><a class="page-link" href="#">Tiếp</a></li>-->
<!--                    </ul>-->
<!--                </nav>-->
<!--            </div>-->
        </div>

<?php

    }
}
