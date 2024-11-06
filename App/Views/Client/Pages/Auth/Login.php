<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class Login extends BaseView
{
    public static function render($data = null)
    {

?>
        <div class="container mt-5 mb-5">
            <h1 class="text-center">Đăng nhập</h1>
            <div class="row">
                <div class="offset-md-3"></div>
                <div class="col-md-6">
                <div class="card card-body mb-5">
                    <form action="/login" method="post">
                        <input type="hidden" name="method" id="" value="POST">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập*</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập..." required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu*</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu..." required>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="remember" id="" value="" checked>
                                Ghi nhớ đăng nhập
                            </label>
                        </div>

                        <button class="btn btn-outline-danger mt-3" type="reset">Nhập lại</button>
                        <button class="btn btn-outline-info mt-3" type="submit">Đăng nhập</button>
                    </form>


                    <a href="/register" class="btn mt-3 text-warning">Chưa có tài khoản? Đăng ký</a>
                    <a href="/forgot-password" class="btn text-danger">Quên mật khẩu</a>

                </div>
                </div>

            </div>
        </div>



<?php

    }
}
