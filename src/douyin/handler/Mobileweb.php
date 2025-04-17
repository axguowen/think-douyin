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
 * 移动/网站应用平台
 */
class Mobileweb extends Base
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 应用ID
        'client_key' => '',
        // 应用密钥
        'client_secret' => '',
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\douyin\\service\\mobileweb\\';

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getClientTokenCacheKey()
    {
        return 'douyin_mobileweb_client_token_' . $this->options['client_key'];
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
            'client_key' => $this->options['client_key'],
            'client_secret' => $this->options['client_secret'],
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
        $clientSecret = $this->options['client_secret'];
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
        $clientSecret = $this->options['client_secret'];
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

    /**
     * 获取Oauth授权跳转接口
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型
     * @return string
     */
    public function getOauthRedirect($redirectUri, $state = '', $scope = 'user_info')
    {
        $clientKey = $this->options['client_key'];
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        return "https://open.douyin.com/platform/oauth/connect/?client_key={$clientKey}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}";
    }

    /**
     * 通过code获取Oauth授权的access_token
     * @access public
     * @param string $code 临时授权码
     * @return array
     */
    public function getOauthAccessToken($code)
    {
        $clientKey = $this->options['client_key'];
        $clientSecret = $this->options['client_secret'];
        // 请求体
        $data = [
            'grant_type' => 'authorization_code',
            'client_key' => $clientKey,
            'client_secret' => $clientSecret,
            'code' => $code,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $requestUrl = 'https://open.douyin.com/oauth/access_token/';
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->parseResponseData($response);
    }

    /**
     * 刷新access_token
     * @access public
     * @param string $refreshToken 刷新token
     * @return array
     */
    public function refreshOauthAccessToken($refreshToken)
    {
        $clientKey = $this->options['client_key'];
        // 请求体
        $data = [
            'client_key' => $clientKey,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $requestUrl = 'https://open.douyin.com/oauth/refresh_token/';
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->parseResponseData($response);
    }

    /**
     * 刷新refresh_token
     * @access public
     * @param string $refreshToken 刷新token
     * @return array
     */
    public function renewOauthRefreshToken($refreshToken)
    {
        $clientKey = $this->options['client_key'];
        // 请求体
        $data = [
            'client_key' => $clientKey,
            'refresh_token' => $refreshToken,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $requestUrl = 'https://open.douyin.com/oauth/renew_refresh_token/';
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->parseResponseData($response);
    }

    /**
     * 获取client_code
     * @access public
     * @return array
     */
    public function getClientCode()
    {
        $clientKey = $this->options['client_key'];
        $clientSecret = $this->options['client_secret'];
        // 请求体
        $data = [
            'client_key' => $clientKey,
            'client_secret' => $clientSecret,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $requestUrl = 'https://open.douyin.com/passport/open/get_client_code';
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->parseResponseData($response);
    }
}