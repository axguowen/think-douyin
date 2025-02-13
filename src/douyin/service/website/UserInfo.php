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

namespace think\douyin\service\website;

use think\douyin\Service;
use axguowen\HttpClient;

/**
 * 用户信息
 */
class UserInfo extends Service
{

    /**
     * 获取用户经营身份状态
     * @access public
     * @param string $openid
     * @param string $douyinShortId
     * @param array $roleLabels
     * @return array
     */
    public function getBusinessStatus($openid = '', $douyinShortId = '', array $roleLabels = ['AUTH_COMPANY'])
    {
        // 请求体
        $data = ['role_labels' => $roleLabels];
        // 如果传了openid，则使用openid
        if (!empty($openid)) {
            $data['openid'] = $openid;
        }
        else{
            $data['douyin_shortId'] = $douyinShortId;
        }
        $url = 'https://open.douyin.com/api/douyin/v1/role/check/';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取用户唯一标识
     * @access public
     * @param string $openId
     * @return array
     */
    public function getRelatedId($openId)
    {
        $url = 'https://open.douyin.com/api/douyin/v1/auth/get_related_id/';
        return $this->handler->callPostApi($url, [
            'open_id' => $openId,
        ]);
    }

    /**
     * 获取client_code
     * @access public
     * @return array
     */
    public function getClientCode()
    {
        $clientKey = $this->handler->getConfig('client_key');
        $clientSecret = $this->handler->getConfig('client_secret');
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
        return $this->handler->parseResponseData($response);
    }

    /**
     * 获取access_code
     * @access public
     * @param string $accessToken 网页授权接口调用凭证
     * @return array
     */
    public function getAccessCode($accessToken)
    {
        // 请求体
        $data = [
            'access_token' => $accessToken,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $requestUrl = 'https://open.douyin.com/passport/open/get_access_code';
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->handler->parseResponseData($response);
    }
}