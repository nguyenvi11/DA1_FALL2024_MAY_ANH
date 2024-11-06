<?php

namespace App\Helpers;

use App\Models\User;

class AuthHelper
{
    public static function login($data)
    {

        $user = new User();
        $result = $user->login($data['username']);
        if ($result) {
            if (password_verify($data['password'], $result['password'])) {
                if ($result['status'] == 0) {
                    NotificationHelper::error('login', 'Tài khoản đã bị khoá');
                    return false;
                    // header('location: /login');
                } else {
                    // $_SESSION['user'] = $result;
                    if ($data['remember']) {
                        self::updateCookie($result['id']);
                    } else {
                        self::updateSession($result['id']);
                    }

                    NotificationHelper::success('login', 'Đăng nhập thành công');
                    return true;
                    // header('location: /');
                }
            } else {
                NotificationHelper::error('login', 'Mật khẩu không chính xác');
                // header('location: /login');
                return false;
            }
        } else {
            NotificationHelper::error('login', 'Tài khoản không tồn tại');
            // header('location: /login');
            return false;
        }
    }
    public static function register($data)
    {

        $user = new User();
        $is_exist = $user->getOneUserByUsernameOrEmail($data['username'], $data['email']);
        if ($is_exist) {
            NotificationHelper::error('register', 'Tên đăng nhập hoặc email đã tồn tại');
            return false;
        } else {
            $result = $user->createUser($data);

            // kiểm tra kết quả
            if ($result) {
                NotificationHelper::success('register', 'Đăng ký thành công');
                return true;
                // header('location: /login');
            } else {
                NotificationHelper::error('register', 'Đăng ký thất bại');
                return false;
                // header('location: /');
            }
        }
    }

    public static function updateCookie($id)
    {

        $user = new User();
        $result = $user->getOneUser($id);
        if ($result) {
            // chuyển array thành string để lưu vào cookie user 
            $user_data = json_encode($result);

            // lưu cookie 
            setcookie('user', $user_data, time() +  3600 * 24 * 30 * 12, '/');
        }
    }
    public static function updateSession($id)
    {

        $user = new User();
        $result = $user->getOneUser($id);
        if ($result) {
            $_SESSION['user'] = $result;
            // echo 'update session';
        }
    }
    public static function checkLogin()
    {
        if (isset($_COOKIE['user'])) {
            $user = $_COOKIE['user'];
            $user_data = json_decode($user);
            $_SESSION['user'] = (array) $user_data;
            return true;
        } elseif (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
    public static function logout()
    {
        unset($_SESSION['user']);
        if (isset($_COOKIE['user'])) {
            setcookie('user', '', time() -  3600 * 24 * 30 * 12, '/');
        }
        NotificationHelper::success('logout', 'Đăng xuất thành công');
        header('location: /');
    }

    public static function edit($id)
    {
        // var_dump($_COOKIE['user']);
        if (self::checkLogin()) {
            $data = $_SESSION['user'];
            $user_id = $data['id'];
            // var_dump($data);
            if ($user_id == $id) {
                return true;
            } else {
                NotificationHelper::error('user_id', 'Không có quyền xem thông tin tài khoản này');
                return false;
                // header("location: /users/$user_id");
            }
        } else {
            NotificationHelper::error('login', 'Vui lòng đăng nhập để xem thông tin');
            return false;

            // header('location: /login');
        }
    }
    public static function update($id, $data)
    {
        if (self::checkLogin()) {
            $session_data = $_SESSION['user'];
            $user_id = $session_data['id'];
            // $user_avatar = $session_data['avatar'];

            // var_dump($_FILES);
            if ($user_id == $id) {
                $is_valid = true;
                $is_upload = true;

                if (isset($_POST['name']) && $_POST['name'] !== '') {
                    $pattern = '/^[a-z A-Z]+$/';
                    if (!preg_match($pattern, $_POST['name'])) {
                        NotificationHelper::error('name', 'Tên không được chứa số hoặc ký tự đặc biệt');
                        $is_valid = false;
                    }
                }
                if (isset($_POST['phone']) && $_POST['phone'] !== '') {
                    $pattern = '/^[0-9]{10}$/';
                    if (!preg_match($pattern, $_POST['phone'])) {
                        NotificationHelper::error('phone', 'Số điện thoại phải 10 số');
                        $is_valid = false;
                    }
                }

                if ($is_valid) {
                    if (file_exists($_FILES['avatar']['tmp_name']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {

                        // nơi lưu trữ hình ảnh (trong source code)
                        $target_dir = "public/uploads/users/";

                        // lấy kiểu file (đuôi file)
                        $imageFileType = strtolower(pathinfo(basename($_FILES["avatar"]["name"]), PATHINFO_EXTENSION));

                        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {

                            // thay đổi tên file thành dạng năm tháng ngày giờ phút giây
                            $nameImage = date('YmdHmi') . '.' . $imageFileType;

                            // đường dẫn đầy đủ để di chuyển file đến
                            $target_file = $target_dir . $nameImage;
                            // nếu upload thành công => lưu vào database
                            if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                                // echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
                                // $nameImage = $user_avatar;
                                NotificationHelper::error('move_upload', 'Không thể tải ảnh vào thư mục lưu trữ');
                                $is_upload = false;
                            }
                        } else {
                            // $nameImage = $user_avatar;

                            NotificationHelper::error('type_upload', 'Chỉ nhận file ảnh JPG, JPEG, PNG & GIF');
                            $is_upload = false;
                        }
                    } else {
                        $is_upload = false;
                    }

                    if ($is_upload) {

                        // mảng dữ liệu để lưu trữ vào database, lưu ý các key phải trùng với tên cột trong database
                        $data = [
                            'name' => $_POST['name'],
                            'phone' => $_POST['phone'],
                            'avatar' => $nameImage,
                        ];
                    } else {
                        $data = [
                            'name' => $_POST['name'],
                            'phone' => $_POST['phone'],
                        ];
                    }
                    $user = new User();
                    $result = $user->updateUser($id, $data);
                    // var_dump($result);
                    if ($result) {
                        if (isset($_SESSION['user'])) {
                            self::updateSession($id);
                        }
                        if (isset($_COOKIE['user'])) {
                            self::updateCookie($id);
                        }
                        NotificationHelper::success('user', 'Cập nhật thông tin tài khoản thành công');
                        return true;
                        // echo ('Cập nhật thông tin tài khoản thành công');
                    } else {
                        NotificationHelper::error('user', 'Cập nhật thông tin tài khoản thất bại');
                        return false;
                        // echo ('Cập nhật thông tin tài khoản thất bại');
                    }
                } else {
                    NotificationHelper::error('user', 'Cập nhật thông tin tài khoản thất bại');
                    return false;
                }
            } else {
                NotificationHelper::error('user_id', 'Không có quyền cập nhật thông tin tài khoản này');
                return false;
            }
        } else {
            NotificationHelper::error('login', 'Vui lòng đăng nhập để xem thông tin');
            // header('location: /login');
            return false;
        }
    }
    public static function changePassword($id, $data)
    {
        $user = new User();
        $result = $user->getOneUser($id);
        if (!$result) {
            NotificationHelper::error('account', 'Tài khoản không tồn tại');
            return false;
        }
        // kiểm tra mật khẩu cũ có trùng khớp với csdl ko
        if (!password_verify($data['old_password'], $result['password'])) {
            NotificationHelper::error('password_verify', 'Mật khẩu cũ không chính xác');
            return false;
        }

        // mã hoá mật khẩu trước khi lưu
        $hash_password = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $data_update = [
            'password' => $hash_password,
        ];

        $result_update = $user->updateUser($id, $data_update);
        if ($result_update) {
            if (isset($_COOKIE['user'])) {
                self::updateCookie($id);
            }
            self::updateSession($id);
            NotificationHelper::success('change-password', 'Đổi mật khẩu thành công');
            return true;
        } else {
            NotificationHelper::error('change-password', 'Đổi mật khẩu thất bại');
            return false;
        }
    }
    public static function forgotPassword($data)
    {
        $user = new User();

        $result = $user->getOneUserByUsername($data['username']);
        return $result;
    }
    public static function resetPassword($data)
    {
        $user = new User();
        $result = $user->updateUserByUsernameAndEmail($data);
        return $result;
    }
}
