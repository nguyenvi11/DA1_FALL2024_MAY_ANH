<?php
namespace App\Controllers\Client;

use App\Views\Client\Pages\Contact\Emailer;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Helpers\NotificationHelper;
use PHPMailer\PHPMailer\PHPMailer;



class ContactController
{
    public function index()
    {
        $success = isset($_GET['success']);
    $error = isset($_GET['error']);
    Header::render();
    Notification::render();
    NotificationHelper::unset();
    Emailer::render(['success' => $success, 'error' => $error]);
    Footer::render();
    }

    public static function sendEmail()

    {
        $is_valid = true;

        // Kiểm tra dữ liệu
        if (empty($_POST['fname']) || empty($_POST['lname'])) {
            NotificationHelper::error('name', 'Họ và tên không được để trống');
            $is_valid = false;
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            NotificationHelper::error('email', 'Email không hợp lệ');
            $is_valid = false;
        }

        if (empty($_POST['message'])) {
            NotificationHelper::error('message', 'Nội dung không được để trống');
            $is_valid = false;
        }
        if ($is_valid) {
            $name = $_POST['fname'] . ' ' . $_POST['lname'];
            $email = $_POST['email'];
            $message = $_POST['message'];



            $mail = new PHPMailer(true);
//            echo '<pre>';
//            print_r($mail);
//            echo '</pre>';
//            die();
            // try {
                // Cấu hình SMTP
//            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'huypqpc09069@gmail.com';
                $mail->Password = 'phmdqnkysverrbht';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($email, 'Hỗ trợ liên hệ');
                $mail->addReplyTo("huypqpc09069@gmail.com", "Dự án 1");
                $mail->addAddress($email, 'Liên Hệ');

                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);
                $mail->Subject = "Liên hệ từ $name";
                $mail->Body = "
            <p>Bạn đã nhận được tin nhắn từ <strong>$name</strong> ($email):</p>
            <p>$message</p>
        ";

                // Gửi email
                if ($mail->send()) {
                    NotificationHelper::success('email', 'Email đã được gửi thành công.');
                } else {
                    NotificationHelper::error('email', 'Không thể gửi email. Lỗi: ' . $mail->ErrorInfo);
                }
        //     } catch (\Exception $e) {
        //         NotificationHelper::error('email', 'Lỗi gửi email: ' . $e->getMessage());
        //     }
        }



        header('Location: /contact');
        exit();
    }

}
