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
class Website extends Base
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
    protected $serviceNamespace = '\\think\\douyin\\service\\website\\';

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getAccessCacheKey()
    {
        return 'douyin_website_access_token_' . $this->options['client_key'];
    }

    /**
     * 强制获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
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
        $accessTokenData = $parseResponseResult[0];
        // 返回
        return [[
            'access_token' => $accessTokenData['access_token'],
            'expires_in' => $accessTokenData['expires_in'],
        ], null];
    }
}