<?php

namespace App\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Models\Category;
use App\Views\Admin\Layouts\Footer;
use App\Views\Admin\Layouts\Header;
use App\Views\Admin\Components\Notification;
use App\Views\Admin\Pages\Category\Create;
use App\Views\Admin\Pages\Category\Edit;
use App\Views\Admin\Pages\Category\Index;

class CategoryController
{


    // hiển thị danh sách
    public static function index()
    {
        // khởi tạo đối tượng model
        $category = new Category;
        $data = $category->getAllCategory();

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
        $is_valid = true;
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            NotificationHelper::error('name', 'Không để trống tên');
            $is_valid = false;
        }
        if (!isset($_POST['status']) || $_POST['status'] === '') {
            NotificationHelper::error('status', 'Không để trống trạng thái');
            $is_valid = false;
        }

        if ($is_valid) {

            // khởi tạo đối tượng model
            $category = new Category();

            $is_exist = $category->getOneCategoryByName($_POST['name']);

            if ($is_exist) {
                NotificationHelper::error('name', 'Tên loại sản phẩm đã tồn tại');
                // chuyển hướng đến trang thêm
                header('location: /admin/categories/create');
            } else {
                // mảng dữ liệu để lưu trữ vào database, lưu ý các key phải trùng với tên cột trong database
                $data = [
                    'name' => $_POST['name'],
                    'status' => $_POST['status']
                ];

                // var_dump($is_exist);
                // thực hiện thêm 
                $result = $category->createCategory($data);

                // kiểm tra kết quả
                if ($result) {
                    NotificationHelper::success('category', 'Thêm thành công');
                } else {
                    NotificationHelper::error('category',  'Thêm thất bại');
                }

                // chuyển hướng đến trang danh sách
                header('location: /admin/categories');
            }
        } else {
            // chuyển hướng đến trang thêm
            header('location: /admin/categories/create');
        }
    }


    // hiển thị chi tiết
    public static function show()
    {
    }


    // hiển thị giao diện form sửa
    public static function edit(int $id)
    {
        // khởi tạo đối tượng model
        $category = new Category();
        $data = $category->getOneCategory($id);
        if ($data) {
            Header::render();
            Notification::render();
            NotificationHelper::unset();
            // hiển thị form sửa
            Edit::render($data);
            Footer::render();
        } else {
            NotificationHelper::error('category',  'Không có loại sản phẩm này');
            header('location: /admin/categories');
        }
    }


    // xử lý chức năng sửa (cập nhật)
    public static function update(int $id)
    {
        $is_valid = true;
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            NotificationHelper::error('name', 'Không để trống tên');
            $is_valid = false;
        }
        if (!isset($_POST['status']) || $_POST['status'] === '') {
            NotificationHelper::error('status', 'Không để trống trạng thái');
            $is_valid = false;
        }

        if ($is_valid) {

            // khởi tạo đối tượng model
            $category = new Category();

            $is_exist = $category->getOneCategoryByName($_POST['name']);

            if ($is_exist && $is_exist['id'] != $id) {
                NotificationHelper::error('name', 'Tên loại sản phẩm đã tồn tại');
                // chuyển hướng đến trang sửa
                header("location: /admin/categories/$id");
            } else {

                $data = [
                    'name' => $_POST['name'],
                    'status' => $_POST['status']
                ];

                $result = $category->updateCategory($id, $data);

                if ($result) {
                    // echo 'Thành công';
                    NotificationHelper::success('category', 'Cập nhật thành công');
                } else {
                    NotificationHelper::error('category', 'Cập nhật thất bại');
                }
                header('location: /admin/categories');
            }
        } else {
            // chuyển hướng đến trang sửa
            header("location: /admin/categories/$id");
        }
    }


    // thực hiện xoá
    public static function delete(int $id)
    {
        $category = new Category();
        $result = $category->deleteCategory($id);
        if ($result) {
            // echo 'Xoá thành công';
            NotificationHelper::success('category', 'Xoá thành công');
        } else {
            NotificationHelper::error('category', 'Xoá thất bại');
        }

        header('location: /admin/categories');
    }
}
