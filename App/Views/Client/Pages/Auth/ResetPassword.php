<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class ResetPassword extends BaseView
{
    public static function render($data = null)
    {

?>
        <div class="container mt-5 mb-5">
            <h1 class="text-center">Đặt lại mật khẩu </h1>
            <div class="row">
                <div class="offset-md-3"></div>
                <div class="col-md-6">
                <div class="card card-body mb-5">
                    <form action="/reset-password" method="post">
                        <input type="hidden" name="method" id="" value="PUT">
                      
                        <div class="form-group">
                            <label for="password">Mật khẩu*</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu..." required>
                        </div>
                        <div class="form-group">
                            <label for="password">Nhập lại mật khẩu *</label>
                            <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Nhập mật khẩu..." required>
                        </div>
                       

                        <button class="btn btn-outline-danger mt-3" type="reset">Nhập lại</button>
                        <button class="btn btn-outline-info mt-3" type="submit">Đặt lại mật khẩu </button>
                    </form>


                    
                </div>
                </div>

            </div>
        </div>



<?php

    }
}
