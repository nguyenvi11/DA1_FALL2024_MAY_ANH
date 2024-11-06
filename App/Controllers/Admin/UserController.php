<?php

namespace App\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Validations\UserValidation;
use App\Views\Admin\Layouts\Footer;
use App\Views\Admin\Layouts\Header;
use App\Views\Admin\Components\Notification;
use App\Views\Admin\Pages\User\Create;
use App\Views\Admin\Pages\User\Edit;
use App\Views\Admin\Pages\User\Index;

class UserController
{


    // hiển thị danh sách
    public static function index()
    {
        // khởi tạo đối tượng model
        $User = new User;
        $data = $User->getAllUser();

        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị giao diện danh sách
        Index::render($data);
        Footer::render();
    }


    // hiển thị giao diện form thêm
    public static function create()
    {
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form thêm
        Create::render();
        Footer::render();
    }


    // xử lý chức năng thêm
    public static function store()
    {

        $username = $_POST['username'];
        // kt ten dang nhap co ton tai chua => ko duoc trung ten dang nhap
        $user = new User();
        $is_exist = $user->getOneUserByUsername($username);
        if ($is_exist) {
            NotificationHelper::error('store', 'Tên người dùng đã tồn tại');
            // chuyển hướng đến trang thêm
            header('location: /admin/users/create');
            exit;
        }
        // thực hiện thêm 
        $data = [
            'username' => $username,
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'status' => $_POST['status'],
        ];

        $is_upload = UserValidation::uploadAvatar();
        if ($is_upload) {
            $data['avatar'] = $is_upload;
        }

        $result = $user->createUser($data);

        // kiểm tra kết quả
        if ($result) {
            NotificationHelper::success('store', 'Thêm người dùng thành công');
        } else {
            NotificationHelper::error('store',  'Thêm người dùng thất bại');
            header('location: /admin/users');
        }

        // chuyển hướng đến trang danh sách
    }


    // // hiển thị chi tiết
    // public static function show()
    // {
    // }


    // hiển thị giao diện form sửa
    public static function edit(int $id)
    {
        // khởi tạo đối tượng model
        $User = new User();
        $data = $User->getOneUser($id);
        if (!$data) {
            NotificationHelper::error('edit',  'Không thể xem người dùng này');
            header('location: /admin/users');
            exit;
        }
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        // hiển thị form sửa
        Edit::render($data);
        Footer::render();
    }


    // xử lý chức năng sửa (cập nhật)
    public static function update(int $id)
    {
        $is_valid = UserValidation::edit();
        if (!$is_valid) {
            NotificationHelper::error('update', 'Cập nhật người dùng thất bại');
            $is_valid = false;
        }
        if (!isset($_POST['status']) || $_POST['status'] === '') {
            NotificationHelper::error('status', 'Không để trống trạng thái');
            header("location: /admin/users/$id");
            exit;
        }
            $user = new User();
                $data = [
                    'email' => $_POST['email'],
                    'name' => $_POST['name'],
                    'status' => $_POST['status']
                ];
                if($_POST['password'] !== ''){
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                $is_upload = UserValidation::uploadAvatar();
                if ($is_upload) {
                    $data['avatar'] = $is_upload;
                }

                $result = $user->updateUser($id, $data);

                if ($result) {
                    NotificationHelper::success('update', 'Cập nhật người dùng thành công');
                    header('location: /admin/users');
                } else {
                    NotificationHelper::error('update', 'Cập nhật người dùng thất bại');
                    header("location: /admin/users/$id");
                }
            }


    // thực hiện xoá
    public static function delete(int $id)
    {
        $User = new User();
        $result = $User->deleteUser($id);
        if ($result) {
            // echo 'Xoá thành công';
            NotificationHelper::success('User', 'Xoá người dùng thành công');
        } else {
            NotificationHelper::error('User', 'Xoá người dùng thất bại');
        }

        header('location: /admin/users');
    }


}
