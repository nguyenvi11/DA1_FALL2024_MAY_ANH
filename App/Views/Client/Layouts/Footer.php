<?php

namespace App\Views\Client\Layouts;

use App\Views\BaseView;

class Footer extends BaseView
{
    public static function render($data = null)
    {
?>

<footer class="footer-section">
    <div class="container relative">
        <div class="sofa-img">
            <img src="../public/assets/client/images/7538.png_860-removebg-preview.png"  alt="Hình ảnh" class="img-fluid">
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="subscription-form">

                    <form action="#" class="row g-3">
                        <div class="col-auto">
                            <input type="text" class="form-control" placeholder="Nhập tên của bạn">
                        </div>
                        <div class="col-auto">
                            <input type="email" class="form-control" placeholder="Nhập email của bạn">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary">
                                <span class="fa fa-paper-plane"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-5 mb-5">
            <div class="col-lg-4">
                <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Camera<span>.</span></a></div>
				<p class="mb-4">Dễ dàng tạo điều kiện cho quá trình phát triển và sắp xếp hợp lý. Mang lại giá trị và hỗ trợ hiệu quả. Kết hợp các yếu tố linh hoạt với tính thẩm mỹ. Định hướng mục tiêu và tối ưu hóa trải nghiệm người dùng.</p>

                <ul class="list-unstyled custom-social">
                    <li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
                </ul>
            </div>

            <div class="col-lg-8">
                <div class="row links-wrap">
                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">Về chúng tôi</a></li>
                            <li><a href="#">Dịch vụ</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Liên hệ</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">Hỗ trợ</a></li>
                            <li><a href="#">Kiến thức cơ bản</a></li>
                            <li><a href="#">Trò chuyện trực tiếp</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">Việc làm</a></li>
                            <li><a href="#">Đội ngũ của chúng tôi</a></li>
                            <li><a href="#">Ban lãnh đạo</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="#">Ghế Nordic</a></li>
                            <li><a href="#">Kruzo Aero</a></li>
                            <li><a href="#">Ghế Ergonomic</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-top copyright">
            <div class="row pt-4">
                <div class="col-lg-6">
                    <p class="mb-2 text-center text-lg-start">Bản quyền &copy;<script>document.write(new Date().getFullYear());</script>. Mọi quyền được bảo lưu. &mdash; Thiết kế bởi <a href="https://untree.co">Untree.co</a> Phân phối bởi <a href="https://themewagon.com">ThemeWagon</a> <!-- Thông tin giấy phép: https://untree.co/license/ -->
                    </p>
                </div>

                <div class="col-lg-6 text-center text-lg-end">
                    <ul class="list-unstyled d-inline-flex ms-auto">
                        <li class="me-4"><a href="#">Điều khoản &amp; Điều kiện</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
         
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="<?= APP_URL ?>/public/assets/client/js/bootstrap.bundle.min.js"></script>
		<script src="<?= APP_URL ?>/public/assets/client/js/tiny-slider.js"></script>
		<script src="<?= APP_URL ?>/public/assets/client/js/custom.js"></script>
        </body>

        </html>


<?php

        // unset($_SESSION['success']);
        // unset($_SESSION['error']);
    }
}

?>