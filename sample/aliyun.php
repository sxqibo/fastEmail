<?php
require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastEmail\AliyunEmail;

$config = [
    // 阿里云信息
    'accessKeyId'     => '',
    'accessKeySecret' => '',

    // 阿里云收件信息
    'accountName'     => '',

    // 收件人信息
    'toAddress'       => '',
    'subject'         => '标题',
    'htmlBody'        => '正文'
];

$result = (new AliyunEmail($config))->email();
print_r($result); // 返回true为成功