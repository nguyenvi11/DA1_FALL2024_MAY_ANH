<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class Register extends BaseView
{
    public static function render($data = null)
    {

?>


        <div class="container mt-5 mb-5">
            <h1 class="text-center">Đăng ký</h1>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="card card-body mb-5">
                        <form action="/register" method="post">
                            <input type="hidden" name="method" id="" value="POST">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập*</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập..." >
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu*</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu..." >
                            </div>
                            <div class="form-group">
                                <label for="re_password">Nhập lại mật khẩu*</label>
                                <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Nhập lại mật khẩu..." >
                            </div>
                            <div class="form-group">
                                <label for="email">Email*</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Nhập email..." >
                            </div>
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên...">
                            </div>

                            <button class="btn btn-outline-danger mt-3" type="reset">Nhập lại</button>
                            <button class="btn btn-outline-info mt-3" type="submit">Đăng ký</button>
                        </form>
                        <a href="/login" class="btn mt-3 text-warning">Đã có tài khoản? Đăng nhập</a>
                    </div>

                </div>

            </div>
        </div>



<?php

    }
}
