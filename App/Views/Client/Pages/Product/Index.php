<?php

namespace App\Views\Client\Pages\Product;

use App\Views\BaseView;
use App\Views\Client\Components\Category;

class Index extends BaseView
{
    public static function render($data = null)
    {
        ?>
        <div class="untree_co-section product-section before-footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <?php
                        Category::render($data['categories']);
                        ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        if (count($data) && count($data['products'])) :
                        ?>
                            <h1 class="text-center mb-3">Sản phẩm</h1>
                            <div class="row">
                                <?php
                                foreach ($data['products'] as $item) :
                                ?>
                                    <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                                        <div class="product-item">
                                            <a href="/products/<?= $item['id'] ?>">
                                                <img src="<?= APP_URL ?>/public/uploads/products/<?= $item['image'] ?>" class="img-fluid product-thumbnail" alt="">
                                                <h3 class="product-title"><?= $item['name'] ?></h3>
                                                <?php if ($item['discount_price'] > 0) : ?>
                                                    <strong class="product-price">
                                                        Giá gốc: <strike><?= number_format($item['price']) ?> đ</strike>
                                                        <br>Giá giảm: <strong class="text-danger"><?= number_format($item['price'] - $item['discount_price']) ?> đ</strong>
                                                    </strong>
                                                <?php else : ?>
                                                    <strong class="product-price"><?= number_format($item['price']) ?> đ</strong>
                                                <?php endif; ?>
                                            </a>
                                            <div class="btn-group">
                                                <form action="/cart/add" method="post">
                                                    <input type="hidden" name="method" value="POST">
                                                    <input type="hidden" name="id" value="<?= $item['id'] ?>" required>
                                                    <button type="submit" class="btn btn-sm btn-outline-success">Thêm vào giỏ hàng</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                        <?php
                        else :
                        ?>
                            <h3 class="text-center text-danger">Không có sản phẩm</h3>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}