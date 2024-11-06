<?php

namespace App\Views\Client\Pages\Auth;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Views\BaseView;

class Edit extends BaseView
{
    public static function render($data = null)
    {

?>


        <div class="container mt-5 mb-5">
            <h1 class="text-center">Thông tin tài khoản</h1>
            <div class="row">
                <div class="offset-md-1 col-md-3">
                    <?php
                    if ($data && $data['avatar']) :
                    ?>
                        <img src="<?= APP_URL ?>/public/uploads/users/<?= $data['avatar'] ?>" alt="" width="100%">
                    <?php
                    else :
                    ?>
                        <img src="<?= APP_URL ?>/public/uploads/users/user1.jpeg" alt="" width="100%">

                    <?php
                    endif;
                    ?>
                </div>

                <div class="col-md-7">
                    <div class="card card-body mb-5">
                        <form action="/users/<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="method" id="" value="PUT">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập*</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?= $data['username'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= $data['email'] ?>" placeholder="Nhập email...">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?= $data['name'] ?>" placeholder="Nhập tên...">
                            </div>
                         
                            <div class="form-group">
                                <label for="avatar">Hình đại diện</label>
                                <input type="file" class="form-control" name="avatar" id="avatar" placeholder="Chọn hình...">
                            </div>

                            <button class="btn btn-outline-danger mb-3" type="reset">Nhập lại</button>
                            <button class="btn btn-outline-info mb-3" type="submit">Cập nhật</button>

                            <a href="/change-password" class="text-danger">Đổi mật khẩu</a>
                            <a href="/reset-password" class="text-danger">Lấy lại mật khẩu</a>

                            <br>
                        </form>
                    </div>

                </div>

            </div>
        </div>



<?php

    }
}
