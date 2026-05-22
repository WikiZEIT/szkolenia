<?php
require_once __DIR__ . '/../../api/lib/common.php';
require_once __DIR__ . '/../../api/lib/stats.php';

$message_sent = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $user_message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');
    if (is_spam()) {
        logBotAttempt('oferta', [
            'honeypot' => $_POST['email_confirmation'] ?? '',
            'email' => $email,
        ]);
        $error_message = "Wygląda na to że nie jesteś człowiem!";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($user_message)) {
        $to = 'jcubic@jcubic.pl';
        $subject = $_POST['subject'];
        $website = trim($_POST['website'] ?? '');
        $sendCopy = !empty($_POST['send_copy']);
        $from = !empty($name) ? $name . ' <' . $email . '>' : $email;

        $messageId = '<form-' . time() . '-' . bin2hex(random_bytes(8)) . '@jcubic.pl>';

        $body = "Wiadomość ze strony " . $page_url . ":\n\n";
        $body .= "From: " . $from . "\n";
        if (!empty($website)) {
            $body .= "Website: " . $website . "\n";
        }
        $body .= "Message:\n" . $user_message;

        $headers = "From: WikiZEIT <jcubic@jcubic.pl>\r\n";
        $headers .= "Reply-To: " . $from . "\r\n";
        $headers .= "Message-ID: " . $messageId . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $body, $headers)) {
            recordSubmission('oferta', $email);

            if ($sendCopy) {
                $copyBody = "Kopia Twojej wiadomości do WikiZEIT:\n\n";
                if (!empty($website)) {
                    $copyBody .= "Website: " . $website . "\n";
                }
                $copyBody .= "Message:\n" . $user_message;

                $copyHeaders = "From: WikiZEIT <jcubic@jcubic.pl>\r\n";
                $copyHeaders .= "References: " . $messageId . "\r\n";
                $copyHeaders .= "Content-Type: text/plain; charset=UTF-8\r\n";

                mail($email, $subject, $copyBody, $copyHeaders);
            }

            $message_sent = true;
        } else {
            $error_message = 'Przepraszam, ale wystąpił błąd wysłania wiadomosci. Spróbuj jeszcze raz.';
        }
    } else {
        $error_message = 'Podaj prawidłowy adres email i wiadomość.';
    }
}
