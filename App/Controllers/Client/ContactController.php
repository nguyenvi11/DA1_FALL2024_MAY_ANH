<?php
namespace App\Controllers\Client;

use App\Views\Client\Pages\Contact\Emailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Helpers\NotificationHelper;


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

    public function sendEmail()
    {
        $data = $_POST;

        // Gửi email
        if ($this->validateEmail($data)) {
            $this->sendEmailLogic($data);
            // Thông báo thành công
            header('Location: /contact?success=1');
            exit();
        } else {
            // Thông báo lỗi
            header('Location: /contact?error=1');
            exit();
        }
    }

    private function validateEmail($data)
    {
        // Xác thực dữ liệu
        return !empty($data['fname']) && !empty($data['lname']) && !empty($data['email']) && !empty($data['message']);
    }

    private function sendEmailLogic($data)
    {
        $mail = new PHPMailer(true);
        try {
            // Cấu hình máy chủ
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Thay thế bằng SMTP server của bạn
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@example.com'; // Email của bạn
            $mail->Password = 'your_password'; // Mật khẩu của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Người gửi và người nhận
            $mail->setFrom('your_email@example.com', 'Tên bạn');
            $mail->addAddress($data['email'], $data['fname'] . ' ' . $data['lname']); // Địa chỉ người nhận

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Tin nhắn mới từ ' . $data['fname'] . ' ' . $data['lname'];
            $mail->Body = $data['message'];

            $mail->send();
        } catch (Exception $e) {
            error_log("Không thể gửi email. Lỗi: {$mail->ErrorInfo}");
        }
    }
}
