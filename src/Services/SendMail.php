<?php

namespace App\Services;

class SendMail
{
    public function sendMail(string $subject, string $message, string $email)
    {
        $to = "mat.micheli99@gmail.com";
        $emailSujet = $subject;
        $emailMessage = $message;
        $headers = "De : " . $email;
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

        $httpCode = 200;
        $httpMessage = "Success";

        if (!mail($to, $emailSujet, $emailMessage, $headers)) {
            $httpCode = 500;
            $httpMessage = "Error";
        }

        http_response_code($httpCode);
        header('Content-Type: application/json');

        echo json_encode(
            array(
            'status' => $httpCode,
            'message' => $httpMessage
            )
        );
    }
}
