<?php 
class ContactController {
    function form() {
        //hiển thị form
        require "view/contact/form.php";
    }

    function send() {
        //send email to shop owner
        // $mailService = new MailService();
        // $to = SHOP_OWNER;
        // $subject = "KiMiShop: Khách hàng liên hệ";
        // $site = get_domain();
        // $name = $_POST["fullname"];
        // $email = $_POST["email"];
        // $mobile = $_POST["mobile"];
        // $message = $_POST["content"];
        // $content = "
        // Hi shop owner,<br>
        // Customer contact info:<br>
        // Name: $name <br>
        // Email: $email <br>
        // Mobile: $mobile <br>
        // Message: $message <br>
        // ========xxx=====<br>
        // Sent from: $site
        // ";
        // $mailService->send($to, $subject, $content);
    }
}
?> 