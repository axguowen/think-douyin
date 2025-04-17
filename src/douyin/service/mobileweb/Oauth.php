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

/**
 * 抖音移动网站应用Oauth授权能力
 */
class Oauth extends Base
{
    /**
     * 拉取用户信息(需scope为user_info)
     * @access public
     * @scope user_info
     * @param string $accessToken
     * @param string $openId
     * @return array
     */
    public function userInfo($accessToken, $openId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/oauth/userinfo/';
        // 请求体
        $data = [
            'access_token' => $accessToken,
            'open_id' => $openId,
        ];
        // 请求头
        $header = [
            'content-type' => 'application/x-www-form-urlencoded',
        ];
        // 返回请求结果
        return $this->callPostApi($url, $data, $header, false);
    }
}
