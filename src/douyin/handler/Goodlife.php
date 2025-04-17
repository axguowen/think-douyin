<?php
// +----------------------------------------------------------------------
// | ThinkPHP Douyin [Simple Douyin Development Kit For ThinkPHP]
// +----------------------------------------------------------------------
// | ThinkPHP 抖音开发工具包
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axguowen <axguowen@qq.com>
// +----------------------------------------------------------------------

namespace think\douyin\handler;

use think\douyin\utils\Tools;
use axguowen\HttpClient;

/**
 * 生活服务商家应用平台
 */
class Goodlife extends Base
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 应用ID
        'app_id' => '',
        // 应用密钥
        'app_secret' => '',
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\douyin\\service\\goodlife\\';

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getClientTokenCacheKey()
    {
        return 'douyin_goodlife_client_token_' . $this->options['app_id'];
    }

    /**
     * 强制获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getClientTokenFromOnline()
    {
        // 接口请求地址
        $requestUrl = 'https://open.douyin.com/oauth/client_token/';
        // 参数
        $data = Tools::arr2json([
            'client_key' => $this->options['app_id'],
            'client_secret' => $this->options['app_secret'],
            'grant_type' => 'client_credential',
        ]);
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
        ];
        // 获取接口调用凭证请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 获取解析结果
        $parseResponseResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseResult[0])){
            return $parseResponseResult;
        }
        $clientTokenData = $parseResponseResult[0];
        // 返回
        return [[
            'client_token' => $clientTokenData['access_token'],
            'expires_in' => $clientTokenData['expires_in'],
        ], null];
    }

    /**
     * 获取通知数据
     * @access public
     * @param string $sign 签名
     * @param string $inputStr input请求数据
     * @return array
     */
    public function getNotifyData($sign, $inputStr)
    {
        // 获取当前密钥
        $clientSecret = $this->options['app_secret'];
        // 验签
        if (Tools::sign($clientSecret, $inputStr) !== $sign) {
            // 返回
            return [null, new \Exception('签名错误')];
        }
        // 签名正确
        $notifyData = json_decode($inputStr, true);
        // 失败
        if(!is_array($notifyData)){
            return [null, new \Exception('数据格式错误')];
        }
        // 返回
        return [$notifyData, null];
    }

    /**
     * 获取服务商通知数据
     * @access public
     * @param string $sign 签名
     * @param string $inputStr input请求数据
     * @param array $httpQuery
     * @return array
     */
    public function getServiceNotifyData($sign, $inputStr, array $httpQuery = [])
    {
        // 获取当前密钥
        $clientSecret = $this->options['app_secret'];
        // 验签
        if (Tools::spiSign($clientSecret, $inputStr, $httpQuery) !== $sign) {
            // 返回
            return [null, new \Exception('签名错误')];
        }
        // 签名正确
        $notifyData = json_decode($inputStr, true);
        // 失败
        if(!is_array($notifyData)){
            return [null, new \Exception('数据格式错误')];
        }
        // 返回
        return [$notifyData, null];
    }
}