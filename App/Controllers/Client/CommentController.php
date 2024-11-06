<?php

namespace App\Controllers\Client;

use App\Helpers\NotificationHelper;
use App\Models\Comment;
use App\Validations\CommentValidation;

class CommentController
{
    // xử lý chức năng thêm

    public static function store()
    {
        // validation các trường dữ liệu
        $is_valid = CommentValidation::createClient();
        if (!$is_valid) {
            NotificationHelper::error('store', 'Thêm bình luận thất bại');
            if (isset($_POST['product_id']) && $_POST['product_id']) {
                $product_id = $_POST['product_id'];
                header("location: /products/$product_id");
            } else {
                header("location: /products");
            }
            exit;
        }
        $product_id = $_POST['product_id'];
        $data = [
            'content' => $_POST['content'],
            'product_id' => $product_id,
            'user_id' => $_POST['user_id'],
        ];

        $comment = new Comment();
        $result = $comment->createComment($data);
        if ($result) {
            NotificationHelper::success('store', 'Thêm bình luận thành công');
        } else {
            NotificationHelper::error('store', 'Thêm bình luận thất bại');
        }

        header("location: products/$product_id");
    }
    public static function delete(int $id)
    {
        $comment = new Comment();
        $result = $comment->deleteComment($id);
        // var_dump($result);

        if ($result) {
            NotificationHelper::success('delete', 'Xoá bình luận thành công');
        } else {
            NotificationHelper::error('delete', 'Xoá bình luận thất bại');
        }

        if (isset($_POST['product_id']) && $_POST['product_id']) {
            $product_id = $_POST['product_id'];
            header("location: /products/$product_id");
        } else {
            header("location: /products");
        }
    }

    public static function update(int $id)
    {
        // validation các trường dữ liệu
        $is_valid = CommentValidation::editClient();
        if (!$is_valid) {
            NotificationHelper::error('update', 'Cập nhật bình luận thất bại');
            if (isset($_POST['product_id']) && $_POST['product_id']) {
                $product_id = $_POST['product_id'];
                header("location: /products/$product_id");
            } else {
                header("location: /products");
            }
            exit;
        }
        // thực hiện cập nhật
        $data = [
            'content' => $_POST['content'],
        ];

        $comment = new Comment();
        $result = $comment->updateComment($id, $data);
        if ($result) {
            NotificationHelper::success('update', 'Cập nhật bình luận thành công');
        } else {
            NotificationHelper::error('update', 'Cập nhật bình luận thất bại');
        }

        if (isset($_POST['product_id']) && $_POST['product_id']) {
            $product_id = $_POST['product_id'];
            header("location: /products/$product_id");
        } else {
            header("location: /products");
        }
    }
    // thực hiện xoá

   
}
