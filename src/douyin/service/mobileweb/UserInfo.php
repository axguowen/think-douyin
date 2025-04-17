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
 * 用户信息
 */
class UserInfo extends Base
{
    /**
     * 获取用户经营身份状态
     * @access public
     * @scope op.business.status
     * @param string $openId
     * @param string $douyinShortId
     * @param array $roleLabels
     * @return array
     */
    public function roleCheck($openId, $douyinShortId = '', array $roleLabels = ['AUTH_COMPANY'])
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/role/check/';
        // 请求体
        $data = [
            'role_labels' => $roleLabels
        ];
        // 如果传了用户抖音号
        if (!empty($douyinShortId)) {
            $data['douyin_shortId'] = $douyinShortId;
        }
        // 否则使用oauth授权用户openid
        else{
            $data['openid'] = $openId;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取用户唯一标识
     * @access public
     * @scope open.account.data
     * @param string $openId
     * @return array
     */
    public function getRelatedId($openId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/auth/get_related_id/';
        // 请求体
        $data = [
            'open_id' => $openId,
        ];
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取access_code
     * @access public
     * @param string $accessToken
     * @return array
     */
    public function getAccessCode($accessToken)
    {
        // 请求地址
        $url = 'https://open.douyin.com/passport/open/get_access_code';
        // 请求体
        $data = [
            'access_token' => $accessToken,
        ];
        // 请求头
        $header = [
            'content-type' => 'application/x-www-form-urlencoded',
        ];
        // 返回结果
        return $this->callPostApi($url, $data, $header, false);
    }
}