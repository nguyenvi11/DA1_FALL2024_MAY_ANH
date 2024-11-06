<?php

namespace App\Views\Client;

use App\Views\BaseView;

class Home extends BaseView
{
    public static function render($data = null)
    {
?>

        <div class="container-fluid">

            <?php if (count($data) && count($data['products'])) : ?>
                <h1 class="text-center mb-3">Sản phẩm nổi bật</h1>
                <div class="row products-container">
                    <?php foreach ($data['products'] as $item) : ?>
                        <div class="col-md-3 product-card">
                            <div class="card mb-4 shadow-sm" style="width: 100%; background-color: #f0f0f0;"> <!-- Thêm background-color: #f0f0f0 -->
                                <img src="<?= APP_URL ?>/public/uploads/products/<?= $item['image'] ?>" class="card-img-top" alt="" style="width: 100%; height: auto;" data-holder-rendered="true">
                                <div class="card-body">
                                    <p class="card-text"><?= $item['name'] ?></p>
                                    <?php if ($item['discount_price'] > 0) : ?>
                                        <p>Giá gốc: <strike><?= number_format($item['price']) ?> đ</strike></p>
                                        <p>Giá giảm: <strong class="text-danger"><?= number_format($item['price'] - $item['discount_price']) ?> đ</strong></p>
                                    <?php else : ?>
                                        <p>Giá tiền: <?= number_format($item['price']) ?> đ</p>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="/products/<?= $item['id'] ?>" type="button" class="btn btn-custom me-2" style="border-radius: 25px;">Chi tiết</a>
                                            <form action="/cart/add" method="post">
                                                <input type="hidden" name="method" value="POST">
                                                <input type="hidden" name="id" value="<?= $item['id'] ?>" required>
                                                <button type="submit" class="btn btn-custom">Thêm vào giỏ hàng</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <h3 class="text-center text-danger">Không có sản phẩm</h3>
            <?php endif; ?>

        </div>
<?php
    }
}
?>




<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <h2 class="section-title">Tại Sao Chọn Chúng Tôi</h2>
                <p>Chúng tôi luôn nỗ lực để mang đến những dịch vụ tốt nhất cho bạn. Với đội ngũ chuyên nghiệp và tận tâm, chúng tôi cam kết mang đến sự hài lòng cho khách hàng.</p>

                <div class="row my-5">
                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="../public/assets/client/images/truck.svg" alt="Image" class="img-fluid">
                            </div>
                            <h3>Giao Hàng Nhanh &amp; Miễn Phí</h3>
                            <p>Chúng tôi cung cấp dịch vụ giao hàng nhanh chóng và miễn phí cho mọi đơn hàng. Hãy trải nghiệm sự tiện lợi này!</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="../public/assets/client/images/bag.svg" alt="Image" class="img-fluid">
                            </div>
                            <h3>Mua Sắm Dễ Dàng</h3>
                            <p>Với giao diện thân thiện và dễ sử dụng, bạn có thể dễ dàng tìm kiếm và đặt hàng chỉ trong vài cú nhấp chuột.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="../public/assets/client/images/support.svg" alt="Image" class="img-fluid">
                            </div>
                            <h3>Hỗ Trợ 24/7</h3>
                            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc, mọi nơi để giải đáp mọi thắc mắc của bạn.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="../public/assets/client/images/return.svg" alt="Image" class="img-fluid">
                            </div>
                            <h3>Đổi Trả Không Rắc Rối</h3>
                            <p>Chúng tôi cam kết hỗ trợ đổi trả sản phẩm một cách dễ dàng và thuận tiện cho bạn.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-wrap">
                    <img src="../public/assets/client/images/mayanh1.jpg" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Why Choose Us Section -->

<!-- Start We Help Section -->
<div class="we-help-section">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="imgs-grid">
                    <div class="grid grid-2">
                        <img src="../public/assets/client/images/mayanh2.jpg" alt="Untree.co">
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ps-lg-5">
                <h2 class="section-title mb-4">Chúng Tôi Giúp Bạn Khám Phá Thế Giới Qua Ống Kính</h2>
                <p>Chúng tôi cung cấp dịch vụ tư vấn và cung cấp máy ảnh chất lượng cao, phù hợp với nhu cầu và sở thích của bạn. Hãy để chúng tôi giúp bạn ghi lại những khoảnh khắc đáng nhớ.</p>

                <ul class="list-unstyled custom-list my-4">
                    <li>Đa dạng dòng máy ảnh phù hợp với mọi cấp độ</li>
                    <li>Cung cấp giải pháp nhiếp ảnh sáng tạo</li>
                    <li>Chuyên nghiệp và tận tâm với khách hàng</li>
                    <li>Giá cả hợp lý và dịch vụ hậu mãi chu đáo</li>
                </ul>

                <p><a href="#" class="btn">Khám Phá</a></p>
            </div>
        </div>
    </div>
</div>
<!-- End We Help Section -->

<!-- Start Popular Product -->
<div class="popular-product">
    <div class="container">
        <div class="row">

        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
    <div class="product-item-sm d-flex">
        <div class="thumbnail">
            <img src="../public/assets/client/images/may-anh-sony-alpha-a6600-kit-18-135mm-oss-den-removebg-preview.png" alt="Camera Image" class="img-fluid">
        </div>
        <div class="pt-3">
            <h3>Máy Ảnh DSLR Canon</h3>
            <p>Máy ảnh DSLR Canon với độ phân giải cao và khả năng chụp ảnh chuyên nghiệp, phù hợp cho người mới và nhiếp ảnh gia chuyên nghiệp.</p>
            <p><a href="#">Đọc Thêm</a></p>
        </div>
    </div>
</div>

<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
    <div class="product-item-sm d-flex">
        <div class="thumbnail">
            <img src="../public/assets/client/images/2_may-anh-ky-thuat-so-sony-zv1-e10-chinh-hang_02fac3295a6740288ab48ebb96b3426b_master-removebg-preview.png" alt="Camera Image" class="img-fluid">
        </div>
        <div class="pt-3">
            <h3>Máy Ảnh Mirrorless Sony</h3>
            <p>Máy ảnh Mirrorless Sony nhỏ gọn với công nghệ tiên tiến, cho phép bạn chụp ảnh và quay video chất lượng cao.</p>
            <p><a href="#">Đọc Thêm</a></p>
        </div>
    </div>
</div>

<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
    <div class="product-item-sm d-flex">
        <div class="thumbnail">
            <img src="../public/assets/client/images/may-anh-sony-dsc-wx800-removebg-preview.png" alt="Camera Image" class="img-fluid">
        </div>
        <div class="pt-3">
            <h3>Máy Ảnh Fujifilm X Series</h3>
            <p>Dòng máy ảnh Fujifilm X Series với thiết kế cổ điển và chất lượng ảnh vượt trội, lý tưởng cho các chuyến du lịch và chụp ảnh nghệ thuật.</p>
            <p><a href="#">Đọc Thêm</a></p>
        </div>
    </div>
</div>

        </div>
    </div>
</div>
<!-- End Popular Product -->

<!-- Start Testimonial Slider -->


        
<!-- End Testimonial Slider -->