<?php

namespace App\Views\Client;

use App\Views\BaseView;

class Blog extends BaseView
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
            <div class="card mb-4 shadow-sm" style="width: 100%; background-color: #f0f0f0;">
                <!-- Thêm background-color: #f0f0f0 -->
                <img src="<?= APP_URL ?>/public/uploads/products/<?= $item['image'] ?>" class="card-img-top" alt=""
                    style="width: 100%; height: auto;" data-holder-rendered="true">
                <div class="card-body">
                    <p class="card-text"><?= $item['name'] ?></p>
                    <?php if ($item['discount_price'] > 0) : ?>
                    <p>Giá gốc: <strike><?= number_format($item['price']) ?> đ</strike></p>
                    <p>Giá giảm: <strong
                            class="text-danger"><?= number_format($item['price'] - $item['discount_price']) ?>
                            đ</strong></p>
                    <?php else : ?>
                    <p>Giá tiền: <?= number_format($item['price']) ?> đ</p>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="/products/<?= $item['id'] ?>" type="button" class="btn btn-custom me-2"
                                style="border-radius: 25px;">Chi tiết</a>
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









<!-- Start Blog Section -->
<div class="blog-section">
    <div class="container">

        <div class="row">

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-1.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">First Time Home Owner Ideas</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Ý tưởng cho người lần đầu mua nhà
                                    Bởi Kristin Watson vào ngày 19 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-2.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">How To Keep Your Furniture Clean</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Cách Giữ Đồ Nội Thất Sạch Sẽ
                                    bởi Robert Fox vào ngày 15 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-3.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Ý tưởng nội thất căn hộ không gian nhỏ
                                    Bởi Kristin Watson vào ngày 12 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-1.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">First Time Home Owner Ideas</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Ý tưởng cho người lần đầu mua nhà
                                    Bởi Kristin Watson vào ngày 19 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-2.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">How To Keep Your Furniture Clean</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Cách Giữ Đồ Nội Thất Sạch Sẽ
                                    bởi Robert Fox vào ngày 15 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-3.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Ý tưởng nội thất căn hộ không gian nhỏ
                                    Bởi Kristin Watson vào ngày 12 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-1.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">First Time Home Owner Ideas</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Ý tưởng cho người lần đầu mua nhà
                                    Bởi Kristin Watson vào ngày 19 tháng 12 năm 2021</a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-2.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">How To Keep Your Furniture Clean</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Cách Giữ Đồ Nội Thất Sạch Sẽ
                                    bởi Robert Fox vào ngày 15 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-5">
                <div class="post-entry">
                    <a href="#" class="post-thumbnail"><img src="../public/assets/client/images/post-3.jpg" alt="Image"
                            class="img-fluid"></a>
                    <div class="post-content-entry">
                        <h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
                        <div class="meta">
                            <span>by <a href="#">Ý tưởng nội thất căn hộ không gian nhỏ
                                    Bởi Kristin Watson vào ngày 12 tháng 12 năm 2021</a></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Blog Section -->



<!-- Start Testimonial Slider -->
<div class="testimonial-section before-footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="section-title">Thành Viên</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="testimonial-slider-wrap text-center">

                    <div id="testimonial-nav">
                        <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                        <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                    </div>

                    <div class="testimonial-slider">

                        <div class="item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 mx-auto">

                                    <div class="testimonial-block text-center">
                                        <blockquote class="mb-5">
                                            <p>Việc thực hiện dễ dàng hơn với những thách thức hàng ngày. Cuộc sống là
                                                một chuỗi những thách thức mà chúng ta phải đối mặt. Hãy sống với sự tự
                                                tin và không ngừng học hỏi. Những điều tốt đẹp sẽ đến với những ai kiên
                                                trì và nỗ lực.</p>
                                        </blockquote>

                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="../public/assets/client/images/person-1.png" alt="Maria Jones"
                                                    class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">Maria Jones</h3>
                                            <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- END item -->

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Testimonial Slider -->