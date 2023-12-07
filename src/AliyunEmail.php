<?php

namespace Sxqibo\FastEmail;

use AlibabaCloud\SDK\Dm\V20151123\Dm;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dm\V20151123\Models\SingleSendMailRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;

class AliyunEmail
{
    /**
     * Endpoint
     * 请参考 https://api.aliyun.com/product/Dm
     */
    const HOST = 'dm.aliyuncs.com';

    /**
     * 必填，您的 AccessKey ID
     */
    private string $accessKeyId;
    /**
     * 必填，您的 AccessKey Secret
     */
    private string $accessKeySecret;
    /**
     * 发送邮件人
     */
    private string $accountName;
    /**
     * 收件人地址
     */
    private string $toAddress;
    /**
     * 邮件标题
     */
    private string $subject;
    /**
     * 邮件详情
     */
    private string $htmlBody;

    public function __construct(array $config = [])
    {
        // 设置默认值或处理缺失的配置项
        $config += [
            'accessKeyId'     => null,
            'accessKeySecret' => null,
            'accountName'     => null,
            'toAddress'       => null,
            'subject'         => null,
            'htmlBody'        => null,
        ];

        // 阿里云 KEY 信息
        $this->accessKeyId     = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        // 阿里云 收件 信息
        $this->accountName = $config['accountName'];
        // 收件人 信息
        $this->toAddress = $config['toAddress'];
        $this->subject   = $config['subject'];
        $this->htmlBody  = $config['htmlBody'];
    }

    /**
     * 使用AK&SK初始化账号Client
     * @return Dm Client
     */
    public function createClient()
    {
        $config = new Config([
            "accessKeyId"     => $this->accessKeyId,    // 必填
            "accessKeySecret" => $this->accessKeySecret // 必填
        ]);

        $config->endpoint = self::HOST;
        return new Dm($config);
    }

    public function email(): bool
    {
        $client                = $this->createClient();
        $singleSendMailRequest = new SingleSendMailRequest([
            "accountName"    => $this->accountName,
            "addressType"    => 1,
            "toAddress"      => $this->toAddress,
            "subject"        => $this->subject,
            "replyToAddress" => true,
            "htmlBody"       => $this->htmlBody,
        ]);
        $runtime               = new RuntimeOptions([]);
        $result = $client->singleSendMailWithOptions($singleSendMailRequest, $runtime);
        if ($result->statusCode == 200) {
            return true;
        } else {
            return false;
        }
    }
}
