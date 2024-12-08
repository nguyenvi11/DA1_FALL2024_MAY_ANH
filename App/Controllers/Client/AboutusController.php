<?php
namespace App\Controllers\Client;

use App\Views\Client\Pages\About\About;
use App\Views\Client\Components\Notification;
use App\Views\Client\Layouts\Footer;
use App\Views\Client\Layouts\Header;
use App\Helpers\NotificationHelper;


class AboutusController
{
    public function index()
    {
        $success = isset($_GET['success']);
        $error = isset($_GET['error']);
        Header::render();
        Notification::render();
        NotificationHelper::unset();
        About::render(['success' => $success, 'error' => $error]);
        Footer::render();
    }
}