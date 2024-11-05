<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class ChangePassword extends BaseView
{
    public static function render($data = null)
    {

?>


        <div class="container mt-5 mb-5">
            <h1 class="text-center">Đổi mật khẩu </h1>
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
                    <div class="card card-body mb-5">
                        <form action="/change-password" method="post">
                            <input type="hidden" name="method" id="" value="PUT">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập*</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập..." disabled value="<?=$data['username']?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu cũ </label>
                                <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Nhập mật khẩu..." >
                            </div>
                            <div class="form-group">
                                <label for="re_password">mật khẩu mới </label>
                                <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Nhập lại mật khẩu..." >
                            </div>
                            <div class="form-group">
                                <label for="re_password">Nhập lại mật khẩu mới  </label>
                                <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Nhập lại mật khẩu..." >
                            </div>
                           

                            <button class="btn btn-outline-danger mt-3" type="reset">Nhập lại</button>
                            <button class="btn btn-outline-info mt-3" type="submit">Đổi mật khẩu</button>
                        </form>
                        <a href="/login" class="btn mt-3 text-warning">Đã có tài khoản? Đăng nhập</a>
                    </div>

                </div>

            </div>
        </div>



<?php

    }
}
