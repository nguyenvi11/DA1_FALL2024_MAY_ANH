<?php
namespace App\Views\Client\Pages\Contact;

use App\Views\BaseView;

class Emailer extends BaseView
{
    public static function render($data = null)
    {
     
        ?>
        <div class="container mt-5 mb-5">
           
        
    <div class="row">
        <!-- Contact Form Column -->
        <div class="col-md-6">
        <h1 class="text-center">Gửi Email</h1>
            <div class="card card-body mb-5">
                <form action="/contact/send" method="post">
                    <div class="form-group">
                        <label for="fname">Tên*</label>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="Nhập tên...">
                    </div>
                    <div class="form-group">
                        <label for="lname">Họ*</label>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Nhập họ...">
                    </div>
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Nhập email...">
                    </div>
                    <div class="form-group mb-5">
                        <label for="message">Nội dung*</label>
                        <textarea class="form-control" name="message" id="message" cols="30" rows="5" placeholder="Nhập nội dung..."></textarea>
                    </div>
                    <button type="reset" class="btn btn-outline-danger">Nhập lại</button>
                    <button type="submit" class="btn btn-outline-info">Gửi Email</button>
                </form>
                <a href="/products" class="btn mt-3 text-warning">Quay lại trang sản phẩm</a>
            </div>
        </div>
        
        <!-- Google Maps Column -->
        <div class="col-md-6">
        <h1 class="text-center">Địa chỉ</h1>

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251460.43336662167!2d105.46063989453127!3d10.011137000000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0893f170bc0c3%3A0x6161339b3a47d9c4!2zTcOBWSDhuqJOSCBWSeG7hlQgTkFNIC0gQ04gQ-G6pk4gVEjGoA!5e0!3m2!1svi!2s!4v1730870262313!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>

                    
                </div>
            </div>
        </div>
        <?php
    }
}
