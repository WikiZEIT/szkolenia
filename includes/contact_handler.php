<?php
$message_sent = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $user_message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');
    if (is_spam()) {
        $error_message = "Wygląda na to że nie jesteś człowiem!";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($user_message)) {
        $to = 'jcubic@jcubic.pl';
        $subject = $_POST['subject'];
        $body = "Wiadomość ze strony " . $page_url . ":\n\n";
        $body .= "From: " . $email . "\n";
        $body .= "Message:\n" . $user_message;

        $headers = "From: jcubic@jcubic.pl\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $message_sent = true;
        } else {
            $error_message = 'Przepraszam, ale wystąpił błąd wysłania wiadomosci. Spróbuj jeszcze raz.';
        }
    } else {
        $error_message = 'Podaj prawidłowy adres email i wiadomość.';
    }
}
