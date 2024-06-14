<?php

namespace Sxqibo\FastEmail;

use PHPMailer\PHPMailer\PHPMailer;

final class FastMail
{
    private static $mail = null;
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getFastMail(array $config = [])
    {
        if (self::$instance == null) {
            self::$instance = new FastMail();

            if (self::$mail == null) {
                self::$mail = new PHPMailer(true);

                self::$mail->CharSet = PHPMailer::CHARSET_UTF8;
                self::$mail->Encoding = PHPMailer::ENCODING_BASE64;
                self::$mail->isSMTP();
                self::$mail->SMTPAuth   = true;
                // 启用加密
//                self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                self::$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                // HTML 格式
                self::$mail->isHTML(true);

                // 邮件推送服务器
                self::$mail->Host       = $config['host'];
                // 端口
                self::$mail->Port       = $config['port'];
                // 发信地址
                self::$mail->Username   = $config['username'];
                // SMTP 密码
                self::$mail->Password   = $config['password'];
                // 显示发信地址,可设置代发
                self::$mail->setFrom($config['username'], $config['name']);
            }
        }

        return self::$instance;
    }

    public function sendMail($emailList, $title, $content, $attachments = [])
    {
        if (!is_array($emailList)) {
            $emailList = [$emailList];
        }
        foreach ($emailList as $email) {
            self::$mail->addAddress($email);               //昵称也可不填
        }

        //Content
        self::$mail->Subject = $title;
        self::$mail->Body    = $content;

        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $filePath = $attachment['path'];
                $name     = $attachment['name'] ?? '';
                self::$mail->addAttachment($filePath, $name);    //名称可选
            }
        }

        self::$mail->Sender = self::$mail->Username;

        try {
            self::$mail->send();
        } catch (\Exception $e) {
            $err = "Message could not be sent. Mailer Error:" . self::$mail->ErrorInfo;
            echo '发送邮件失败，失败原因：' . $err;
            return false;
        }

        return true;
    }
}
