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
 * 关系能力
 */
class Relation extends Base
{
    /**
     * 获取用户视频情况
     * @access public
     * @scope data.external.user
     * @param string $accessToken
     * @param string $openId
     * @param int $dateType
     * @return array
     */
    public function dataExternalUserItem($accessToken, $openId, $dateType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/user/item/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'date_type' => $dateType,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户视频情况
     * @access public
     * @scope data.external.user
     * @param string $accessToken
     * @param string $openId
     * @param int $dateType
     * @return array
     */
    public function dataExternalUserFans($accessToken, $openId, $dateType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/user/fans/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'date_type' => $dateType,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户点赞数
     * @access public
     * @scope data.external.user
     * @param string $accessToken
     * @param string $openId
     * @param int $dateType
     * @return array
     */
    public function dataExternalUserLike($accessToken, $openId, $dateType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/user/like/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'date_type' => $dateType,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户评论数
     * @access public
     * @scope data.external.user
     * @param string $accessToken
     * @param string $openId
     * @param int $dateType
     * @return array
     */
    public function dataExternalUserComment($accessToken, $openId, $dateType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/user/comment/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'date_type' => $dateType,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户分享数
     * @access public
     * @scope data.external.user
     * @param string $accessToken
     * @param string $openId
     * @param int $dateType
     * @return array
     */
    public function dataExternalUserShare($accessToken, $openId, $dateType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/user/share/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'date_type' => $dateType,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户主页访问数
     * @access public
     * @scope data.external.user
     * @param string $accessToken
     * @param string $openId
     * @param int $dateType
     * @return array
     */
    public function dataExternalUserProfile($accessToken, $openId, $dateType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/user/profile/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'date_type' => $dateType,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户主页访问数
     * @access public
     * @scope fans.check
     * @param string $accessToken
     * @param string $openId
     * @param string $followerOpenId
     * @return array
     */
    public function fansCheck($accessToken, $openId, $followerOpenId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/fans/check/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'follower_open_id' => $followerOpenId,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户粉丝数据
     * @access public
     * @scope fans.data.bind​
     * @param string $accessToken
     * @param string $openId
     * @return array
     */
    public function userFansData($accessToken, $openId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/user/fans_data/';
        // 请求体
        $data = [
            'open_id' => $openId,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户粉丝来源
     * @access public
     * @scope data.external.fans_source
     * @param string $accessToken
     * @param string $openId
     * @return array
     */
    public function dataExternFansSource($accessToken, $openId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/extern/fans/source/';
        // 请求体
        $data = [
            'open_id' => $openId,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户粉丝喜好
     * @access public
     * @scope data.external.fans_favourite
     * @param string $accessToken
     * @param string $openId
     * @return array
     */
    public function dataExternFansFavourite($accessToken, $openId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/extern/fans/favourite/';
        // 请求体
        $data = [
            'open_id' => $openId,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }

    /**
     * 获取用户粉丝热评
     * @access public
     * @scope data.external.fans_favourite
     * @param string $accessToken
     * @param string $openId
     * @return array
     */
    public function dataExternFansComment($accessToken, $openId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/extern/fans/comment/';
        // 请求体
        $data = [
            'open_id' => $openId,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callGetApi($url, $data, $header);
    }
}