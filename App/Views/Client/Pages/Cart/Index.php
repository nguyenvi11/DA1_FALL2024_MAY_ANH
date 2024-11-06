<?php

namespace App\Views\Client\Pages\Cart;

use App\Helpers\AuthHelper;
use App\Views\BaseView;

class Index extends BaseView
{
    public static function render($data = null)
    {

        $is_login = AuthHelper::checkLogin();


?>


        <div class="container mt-5 mb-5">
            <h1 class="text-center">Giỏ hàng</h1>


            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Tên</th>
                        <th>Giá tiền</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    $i = 0;
                    foreach ($data as $cart) :
                        if ($cart['data']) :

                            $unit_price = $cart['quantity'] * ($cart['data']['price'] - $cart['data']['discount_price']);
                            $total_price += $unit_price;
                            $i++;
                    ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $cart['data']['id'] ?></td>
                                <td><img src="<?= APP_URL ?>/public/uploads/products/<?= $cart['data']['image'] ?>" alt="" width="200px"></td>
                                <td><?= $cart['data']['name'] ?></td>

                                <?php
                                if ($cart['data']['discount_price'] > 0) :
                                ?>
                                    <td>
                                        <strike><?= number_format($cart['data']['price']) ?></strike>
                                        <br>
                                        <?= number_format($cart['data']['price'] - $cart['data']['discount_price']) ?>
                                    </td>

                                <?php

                                else :
                                ?>
                                    <td>
                                        <?= number_format($cart['data']['price']) ?>
                                    </td>
                                <?php

                                endif;
                                ?>
                                <td>
                                    <form action="/cart/update" method="post">
                                        <input type="hidden" name="method" id="" value="PUT">
                                        <input type="number" name="quantity" value="<?= $cart['quantity'] ?>" onchange="this.form.submit()" class="form-control" min=1>
                                        <input type="hidden" name="id" value="<?= $cart['data']['id'] ?>">
                                        <input type="hidden" name="update-cart-item">
                                    </form>
                                </td>
                                <td><?= number_format($unit_price) ?></td>
                                <td>
                                    <form action="cart/delete" method="post">
                                        <input type="hidden" name="method" id="" value="DELETE">
                                        <input type="hidden" name="id" value="<?= $cart['data']['id'] ?>">
                                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </td>

                            </tr>


                    <?php
                        endif;
                    endforeach;
                    ?>


                </tbody>
            </table>

            <h2>Tổng tất cả: <?= number_format($total_price)  ?>đ</h2>

            <div class="mt-5">
                <div class="d-flex justify-content-between">
                    <form action="/cart/delete-all" method="post">
                        <input type="hidden" name="method" id="" value="DELETE">
                        <button class="btn btn-outline-danger" name="delete-cart" type="submit">Xoá giỏ hàng</button>
                        
                    </form>

                    <?php
                    if ($is_login) :
                    ?>
                        <a href="/checkout" class="btn btn-outline-dark">Thanh toán</a>

                    <?php
                    else :
                    ?>
                        <h4 class="text-center text-danger">
                            <button type="button" class="btn btn-outline-dark"> Vui lòng đăng nhập để thanh toán</button>

                        </h4>
                    <?php
                    endif;
                    ?>


                </div>


            </div>

        </div>





<?php

    }
}
