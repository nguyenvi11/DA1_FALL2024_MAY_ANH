<?php




namespace App\Controllers\Client;

use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Views\Client\Pages\Auth\Register;
use App\Views\Client\Pages\Auth\Login;
use App\Helpers\AuthHelper;
use App\Helpers\NotificationHelper;
use App\Views\Client\Components\Notification;
use App\Validations\AuthValidation;
use App\Views\Client\Pages\Auth\Edit;
use App\Views\Client\Pages\Auth\ChangePassword;
use App\Views\Client\Pages\Auth\ForgotPassword;
use App\Views\Client\Pages\Auth\ResetPassword;






class AuthController
{
    public static function register()
    {
        // hiển thị thông báo.
        Notification::render();
        // huy session thông báo1.
        NotificationHelper::unset();
        // hiển thị form đăng ký
        // hiển thị header// 
        Header::render();
        Register::render();
        Footer::render();
    }

    public static function login()
    {
        // hiển thị thông báo.
        Notification::render();
        // huy session thông báo1.
        NotificationHelper::unset();
        // hiển thị form đăng ký
        // hiển thị header// 
        Header::render();
        Login::render();
        Footer::render();
    }

    // thực hiệnt đăng ký.

    public static function registerAction()
    {

        $is_valid = true;
        if (!isset($_POST['username']) || $_POST['username'] === ' ') {
            NotificationHelper::error('username', 'Không để trống tên đăng nhập');
            $is_valid = false;
        }


        if (!$is_valid) {
            NotificationHelper::error('register_valid', 'Đăng ký thất bại');
            header('location: /register');
            exit();
        }
        // bắt tôi validation
        // lấy dữ liệu người dùng nhập vào
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $name = $_POST['name'];
        // đưa dữ liệu vào nặng, lưu ý "key" phải trùng với tên cột trong cơ sở dữ liệu
        $data = [
            'username' => $username,
            'password' => $hash_password,
            'email' => $email,
            'name' => $name
        ];

        $result = AuthHelper::register($data);
        if ($result) {
            // var_dump('Them oki');
            header('location: /');
        } else {
            // var_dump('Them loi');
            header('location: /register');
        }
    }




    public static function loginAction()
    {
        // bắt lỗi
        $is_valid = AuthValidation::login();
        if (!$is_valid) {
            NotificationHelper::error('Login', 'Đăng nhập thất bại');
            header('location: /login');
            exit;
        }

        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'remember' => isset($_POST['remember'])
        ];

        $result = AuthHelper::login($data);
        if ($result) {
            NotificationHelper::success('Login', 'Đăng nhập thành công');
            header('location: /');
        } else {
            NotificationHelper::error('login', 'Đăng nhập thất bại');
            header('location: /login');
        }
    }


    public static function logout()
    {
        AuthHelper::logout();
        NotificationHelper::success('logout', 'Đăng xuất thành công');
        header('location: /');
    }

    public static function edit($id)
    {
        $result = AuthHelper::edit($id);
        if (!$result) {
            if (isset($_SESSION['error']['login'])) {
                header('location: /login');
                exit;
            }
            if (isset($_SESSION['error']['user_id'])) {
                $data = $_SESSION['user'];
                $user_id = $data['id'];
                header("location: /users/edit/$user_id");
                exit;
            }
        }

        $data = $_SESSION['user'];
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // giao diện thông tin user
        Edit::render($data);
        // var_dump($data);
        Footer::render();
    }
    public static function update($id)
    {

        $is_valid = AuthValidation::edit();
        if (!$is_valid) {
            NotificationHelper::error('update_user', 'Cập nhật thông tin tài khoản thất bại');
            header("location: /users/$id");
            exit;
        }


        $data = [
            'email' => $_POST['email'],
            'name' => $_POST['name']
        ];
        // kiểm tra có upload hình ảnh ko, nếu có kt có hợp lệ ko 
        $is_upload = AuthValidation::uploadAvatar();
        if ($is_upload) {
            $data['avatar'] = $is_upload;
        }
        // goi helper de update
        $result = AuthHelper::update($id, $data);
        // kt kết quả trả về và chuyển hướng
        header("location: /users/$id");
    }
    public static function changePassword()
    {
        $is_login = AuthHelper::checkLogin();
        if (!$is_login) {
            NotificationHelper::error('login', 'Vui lòng đăng nhập để đổi mật khẩu');
            header('location: /login');
            exit;
        }


        $data = $_SESSION['user'];
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        ChangePassword::render($data);
        Footer::render();
    }
    public static function changePasswordAction()
    {
        // validation
        $is_valid = AuthValidation::changePassword();
        if (!$is_valid) {
            NotificationHelper::error('change-password', 'Đổi mật khẩu thất bại');
            header('location: /change-password');
            exit;
        }
        $id = $_SESSION['user']['id'];
        $data = [
            'old_password' => $_POST['old_password'],
            'new_password' => $_POST['new_password'],
        ];
        // gọi AuthHelper
        $result = AuthHelper::changePassword($id, $data);
        header('location: /change-password');
    }
    public static function forgotPassword()
    {

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        ForgotPassword::render();
        Footer::render();
    }
    public static function forgotPasswordAction()
    {
        // validation
        $is_valid = AuthValidation::forgotPassword();
        if (!$is_valid) {
            NotificationHelper::error('forgot_password', 'Lấy lại mật khẩu thất bại');
            header('location: /forgot-password');
            exit;
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $data = [
            'username' => $username

        ];
        // AuthHelper
        $result = AuthHelper::forgotPassword($data);
        if (!$result) {
            NotificationHelper::error('username_exist', 'Không tồn tại tài khoản này');
            header('location: /forgot-password');
            exit;
        }
        if ($result['email'] != $email) {
            NotificationHelper::error('email_exist', 'Email không đúng');
            header('location: /forgot-password');
            exit;
        }
        $_SESSION['reset_password'] = [
            'username' => $username,
            'email' => $email
        ];
        header('location: /reset-password');
        // echo 'Thanh cong';
    }
    public static function resetPassword()
    {
        if(!isset($_SESSION['reset_password'])){
            NotificationHelper::error('reset_password', 'Vui lòng nhập đầy đủ thông tin của form này');
            header('location: /forgot-password');
            exit;
            }

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        ResetPassword::render();
        Footer::render();
    }
    public static function resetPasswordAction()
    {
        // validation
        $is_valid = AuthValidation::resetPassword();
        if (!$is_valid) {
            NotificationHelper::error('reset_password', 'Đặt lại mật khẩu thất bại');
            header('location: /reset-password');
            exit;
        }
        $password = $_POST['password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'username' => $_SESSION['reset_password']['username'],
            'email' => $_SESSION['reset_password']['email'],
            'password' => $hash_password
        ];
        $result = AuthHelper::resetPassword($data);
        if ($result) {
            NotificationHelper::success('reset_password', 'Đặt lại mật khẩu thành công');
            unset($_SESSION['reset_password']);
            header('location: /login');
        } else {
            NotificationHelper::error('reset_password', 'Đặt lại mật khẩu thất bại');
            header('location: /reset-password');
        }
    }
}
