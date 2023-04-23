<?php

namespace App\Utils\SendEmail;

use PHPMailer\PHPMailer\PHPMailer;
use Exception;
use stdClass;

class Email
{

    /**@var PHPMailer */
    private $mail;

    /**@var stdClass */
    private $data;

    /**@var Exception */
    private $error;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->data = new stdClass();

        $this->mail->isSMTP(true);
        $this->mail->isHTML();
        $this->mail->setLanguage("br");

        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = "TLS";
        $this->mail->CharSet = "utf-8";
        $this->mail->Host = MAIL["host"];
        $this->mail->Port = MAIL["port"];
        $this->mail->Username = MAIL["user"];
        $this->mail->Password = MAIL['password'];
    }

    /**
     * Recebe Quatro Strings e retorna um Tipo EMAIL Class
     * @param string $subject
     * @param string $body
     * @param string $recipient_name
     * @param string $recipient_email
     * @return $this
     */
    public function add(string $subject, string $body, string $recipient_name, string $recipient_email): Email
    {
        $this->data->subject         = $subject;
        $this->data->body            = $body;
        $this->data->recipient_name  = $recipient_name;
        $this->data->recipient_email = $recipient_email;

        return $this;
    }

    /**
     * Recebe duas Strings e retorna um Tipo EMAIL Class
     * @param string $filePath
     * @param string $fileName
     * @return $this
     */
    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attach[$filePath] = $fileName;
        return $this;
    }

    /**
     * Recebe duas Strings e retorna um Bool
     * @param array $from_name
     * @param array $from_email
     * @return bool
     */
    public function send(string $from_name = MAIL["from_name"], string $from_email = MAIL["from_email"]): bool
    {   
        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->setFrom($from_email, $from_name);

            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            $this->error = $e;
            return false;
        }
    }

    public function error(): ?Exception
    {
        return $this->error;
    }
}
