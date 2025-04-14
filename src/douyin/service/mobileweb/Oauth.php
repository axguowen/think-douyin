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

namespace think\douyin\service\mobileweb;

use think\douyin\Service;
use think\douyin\utils\Tools;
use axguowen\HttpClient;

/**
 * 抖音网页授权
 */
class Oauth extends Service
{
    /**
     * Oauth 授权跳转接口
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型
     * @return string
     */
    public function getOauthRedirect($redirectUri, $state = '', $scope = 'user_info')
    {
        $clientKey = $this->handler->getConfig('client_key');
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        return "https://open.douyin.com/platform/oauth/connect/?client_key={$clientKey}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}";
    }

    /**
     * 通过 code 获取 AccessToken 和 openid
     * @access public
     * @param string $code 授权Code值
     * @return array
     */
    public function getAccessToken($code)
    {
        $clientKey = $this->handler->getConfig('client_key');
        $clientSecret = $this->handler->getConfig('client_secret');
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
        return $this->handler->parseResponseData($response);
    }

    /**
     * 刷新refresh_token
     * @access public
     * @return array
     */
    public function renewRefreshToken()
    {
        $clientKey = $this->handler->getConfig('client_key');
        // 刷新凭证
        $refreshToken = $this->handler->getConfig('oauth_refresh_token');
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
        return $this->handler->parseResponseData($response);
    }

    /**
     * 刷新AccessToken并续期
     * @access public
     * @return array
     */
    public function refreshAccessToken()
    {
        $clientKey = $this->handler->getConfig('client_key');
        // 刷新凭证
        $refreshToken = $this->handler->getConfig('oauth_refresh_token');
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
        return $this->handler->parseResponseData($response);
    }

    /**
     * 拉取用户信息(需scope为user_info)
     * @access public
     * @param string $openId 用户的唯一标识
     * @return array
     */
    public function getUserInfo($openId)
    {
        // oauth凭证
        $accessToken = $this->handler->getConfig('oauth_access_token');
        // 请求体
        $data = [
            'access_token' => $accessToken,
            'open_id' => $openId,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $requestUrl = 'https://open.douyin.com/oauth/userinfo/';
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->handler->parseResponseData($response);
    }
}
