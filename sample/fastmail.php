<?php
require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastEmail\FastMail;

$config = [
    // 服务器地址
    'host'     => 'ssl://smtpdm.aliyun.com',
    // 服务器端口
    'port'     => 465,
    // 用户名
    'username' => '',
    // 密码
    'password' => '',
    // 发件者显示的名称
    'name'     => '',

    // 下面是选填，根据实际情况吧
    // 'charset' => 'UTF-8',
    // 'smpt_secure' => 'ssl',
    // 'auth' => true
];

$attachments = [
    [
        'name' => '附件名称',
        // 附件路径
        'path' => '/Users/apple/Desktop/test.xlsx'
    ],
];

FastMail::getFastMail($config)
    ->sendMail('test@qq.com', '标题', '内容', $attachments);