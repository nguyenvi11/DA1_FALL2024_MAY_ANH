<?php

namespace App\Views\Client\Components;

use App\Views\BaseView;

class PriceFilter extends BaseView
{
    public static function render($data = null)
    {
        ?>
        <!-- Form Lọc Giá -->
        <div class="mt-4">
            <h5>Lọc giá</h5>
            <form action="/products/category/<?= $data['category_id'] ?>" method="get">
                <div class="form-group">
                    <label for="min_price">Giá thấp nhất:</label>
                    <input type="number" name="min_price" id="min_price" class="form-control" placeholder="VNĐ">
                </div>
                <div class="form-group">
                    <label for="max_price">Giá cao nhất:</label>
                    <input type="number" name="max_price" id="max_price" class="form-control" placeholder="VNĐ">
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Lọc</button>
            </form>
        </div>
        <?php
    }
}
