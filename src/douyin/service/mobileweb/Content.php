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
 * 内容能力
 */
class Content extends Base
{
    /**
     * 查询授权账号视频列表
     * @access public
     * @scope video.list.bind
     * @param string $accessToken
     * @param string $openId
     * @param int $cursor
     * @param int $count
     * @return array
     */
    public function videoList($accessToken, $openId, $cursor = 0, $count = 10)
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/video/video_list/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'count' => $count,
            'cursor' => $cursor,
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
     * 查询特定视频的视频数据
     * @access public
     * @scope video.data.bind
     * @param string $accessToken
     * @param string $openId
     * @param array $videoIds
     * @param array $itemIds
     * @return array
     */
    public function videoData($accessToken, $openId, array $videoIds = [], array $itemIds = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/user/fans/?open_id=' . $openId;
        // 请求体
        $data = [];
        if (!empty($videoIds)) {
            $data['video_ids'] = $videoIds;
        }
        else{
            $data['item_ids'] = $itemIds;
        }
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callPostApi($url, $data, $header);
    }

    /**
     * 查询视频发布结果
     * @access public
     * @scope aweme.forward
     * @param string $defaultHashtag
     * @param bool $needCallback
     * @return array
     */
    public function shareId($defaultHashtag, $needCallback = false)
    {
        // 请求地址
        $url = 'https://open.douyin.com/share-id/';
        // 请求体
        $data = [
            'default_hashtag' => $defaultHashtag,
            'need_callback' => $needCallback,
        ];
        // 返回
        return $this->handler->callGetApi($url, $data, $header);
    }

    /**
     * 查询视频发布结果
     * @access public
     * @scope poi.search
     * @param string $keyword
     * @param string $city
     * @param int $cursor
     * @param int $count
     * @return array
     */
    public function poiSearchKeyword($keyword, $city = '', $cursor = 0, $count = 10)
    {
        // 请求地址
        $url = 'https://open.douyin.com/poi/search/keyword/';
        // 请求体
        $data = [
            'keyword' => $keyword,
            'count' => $count,
        ];
        if (!empty($city)) {
            $data['city'] = $city;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        // 返回
        return $this->handler->callGetApi($url, $data, $header);
    }

    /**
     * 通过VideoID获取IFrame代码
     * @access public
     * @param string $videoId
     * @return array
     */
    public function getIframeByVideo($videoId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/video/get_iframe_by_video';
        // 请求体
        $data = [
            'video_id' => $videoId,
        ];
        // 返回
        return $this->callGetApi($url, $data);
    }

    /**
     * 通过ItemID获取IFrame代码
     * @access public
     * @param string $itemID
     * @return array
     */
    public function getIframeByItem($itemID)
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/video/get_iframe_by_item';
        // 请求体
        $data = [
            'item_id' => $itemID,
            'client_key' => $this->handler->getConfig('client_key'),
        ];
        // 返回
        return $this->callGetApi($url, $data);
    }

    /**
     * 创建投稿任务
     * @access public
     * @scope task.posting.create
     * @param string $taskName
     * @param array $taskCondition
     * @param int $startTime
     * @param int $endTime
     * @return array
     */
    public function taskPostingCreate($taskName, array $taskCondition, $startTime, $endTime)
    {
        // 请求地址
        $url = 'https://open.douyin.com/task/posting/create/';
        // 请求体
        $data = [
            'task_name' => $taskName,
            'task_condition' => $taskCondition,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 绑定视频
     * @access public
     * @scope posting.behavior
     * @param string $accessToken
     * @param string $openId
     * @param string $taskId
     * @param string $videoId
     * @return array
     */
    public function taskPostingBindVideo($accessToken, $openId, $taskId, $videoId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/task/posting/bind_video/?open_id=' . $openId;
        // 请求体
        $data = [
            'task_id' => $taskId,
            'video_id' => $videoId,
        ];
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callPostApi($url, $data, $header);
    }

    /**
     * 销毁投稿任务
     * @access public
     * @scope task.posting.user_verification
     * @param string $taskId
     * @param string $targetOpenId
     * @param string $videoId
     * @return array
     */
    public function taskPostingUser($taskId, $targetOpenId, $videoId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/task/posting/user/';
        // 请求体
        $data = [
            'task_id' => $taskId,
            'target_open_id' => $targetOpenId,
            'video_id' => $videoId,
        ];
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询视频基础信息
     * @access public
     * @scope posting.behavior
     * @param string $accessToken
     * @param string $openId
     * @param array $videoIds
     * @param array $itemIds
     * @return array
     */
    public function videoBasicInfo($accessToken, $openId, array $videoIds = [], array $itemIds = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/video/video_basic_info/?open_id=' . $openId;
        // 请求体
        $data = [];
        if (!empty($videoIds)) {
            $data['video_ids'] = $videoIds;
        }
        else{
            $data['item_ids'] = $itemIds;
        }
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callPostApi($url, $data, $header);
    }

    /**
     * 获取视频基础数据
     * @access public
     * @scope data.external.item
     * @param string $accessToken
     * @param string $openId
     * @param string $itemId
     * @return array
     */
    public function dataExternalItemBase($accessToken, $openId, $itemId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/item/base/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'item_id' => $itemId,
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
     * 获取视频点赞数据
     * @access public
     * @scope data.external.item
     * @param string $accessToken
     * @param string $openId
     * @param string $itemId
     * @param int $dataType
     * @return array
     */
    public function dataExternalItemLike($accessToken, $openId, $itemId, $dataType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/item/like/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'item_id' => $itemId,
            'data_type' => $dataType,
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
     * 获取视频评论数据
     * @access public
     * @scope data.external.item
     * @param string $accessToken
     * @param string $openId
     * @param string $itemId
     * @param int $dataType
     * @return array
     */
    public function dataExternalItemComment($accessToken, $openId, $itemId, $dataType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/item/comment/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'item_id' => $itemId,
            'data_type' => $dataType,
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
     * 获取视频播放数据
     * @access public
     * @scope data.external.item
     * @param string $accessToken
     * @param string $openId
     * @param string $itemId
     * @param int $dataType
     * @return array
     */
    public function dataExternalItemPlay($accessToken, $openId, $itemId, $dataType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/item/play/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'item_id' => $itemId,
            'data_type' => $dataType,
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
     * 获取视频分享数据
     * @access public
     * @scope data.external.item
     * @param string $accessToken
     * @param string $openId
     * @param string $itemId
     * @param int $dataType
     * @return array
     */
    public function dataExternalItemShare($accessToken, $openId, $itemId, $dataType = 7)
    {
        // 请求地址
        $url = 'https://open.douyin.com/data/external/item/share/';
        // 请求体
        $data = [
            'open_id' => $openId,
            'item_id' => $itemId,
            'data_type' => $dataType,
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
     * H5分享视频跳转链接获取
     * @access public
     * @scope jump.basic
     * @param string $clientTicket
     * @param int $expireAt
     * @param string $videoPath
     * @param string $title
     * @param string $state
     * @param array $hashtagList
     * @param array $microAppInfo
     * @param string $poiId
     * @param int $shareToPublish
     * @return array
     */
    public function schemaGetShareVideo($clientTicket, $expireAt, $videoPath, $title = '', $state = '', array $hashtagList = [], array $microAppInfo = [], $poiId = '', $shareToPublish = 0)
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/schema/get_share/';
        // 请求体
        $data = [
            'client_ticket' => $clientTicket,
            'expire_at' => $expireAt,
            'video_path' => $videoPath,
            'share_to_publish' => $shareToPublish,
        ];
        if(!empty($title)){
            $data['title'] = $title;
        }
        if(!empty($state)){
            $data['state'] = $state;
        }
        if(!empty($hashtagList)){
            $data['hashtag_list'] = $hashtagList;
        }
        if(!empty($microAppInfo)){
            $data['micro_app_info'] = $microAppInfo;
        }
        if(!empty($poiId)){
            $data['poi_id'] = $poiId;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * H5分享图片跳转链接获取
     * @access public
     * @scope jump.basic
     * @param string $clientTicket
     * @param int $expireAt
     * @param string $imagePath
     * @param array $imageListPath
     * @param string $state
     * @param array $hashtagList
     * @param array $microAppInfo
     * @param string $poiId
     * @return array
     */
    public function schemaGetShareImage($clientTicket, $expireAt, $imagePath, array $imageListPath = [], $state = '', array $hashtagList = [], array $microAppInfo = [], $poiId = '')
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/schema/get_share/';
        // 请求体
        $data = [
            'client_ticket' => $clientTicket,
            'expire_at' => $expireAt,
        ];
        if(!empty($imagePath)){
            $data['image_path'] = $imagePath;
        }
        else{
            $data['image_list_path'] = $imageListPath;
        }
        if(!empty($state)){
            $data['state'] = $state;
        }
        if(!empty($hashtagList)){
            $data['hashtag_list'] = $hashtagList;
        }
        if(!empty($microAppInfo)){
            $data['micro_app_info'] = $microAppInfo;
        }
        if(!empty($poiId)){
            $data['poi_id'] = $poiId;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 个人页跳转链接获取
     * @access public
     * @scope jump.basic
     * @param int $expireAt
     * @param string $openId
     * @param string $account
     * @return array
     */
    public function schemaGetUserProfile($expireAt, $openId = '', $account = '')
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/schema/get_user_profile/';
        // 请求体
        $data = [
            'expire_at' => $expireAt,
        ];
        if(!empty($openId)){
            $data['open_id'] = $openId;
        }else{
            $data['account'] = $account;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 个人会话页跳转链接获取
     * @access public
     * @scope jump.basic
     * @param int $expireAt
     * @param string $openId
     * @param string $account
     * @return array
     */
    public function schemaGetChat($expireAt, $openId = '', $account = '')
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/schema/get_chat/';
        // 请求体
        $data = [
            'expire_at' => $expireAt,
        ];
        if(!empty($openId)){
            $data['open_id'] = $openId;
        }else{
            $data['account'] = $account;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 视频详情页跳转链接获取
     * @access public
     * @scope jump.basic
     * @param int $expireAt
     * @param int $videoId
     * @param string $itemId
     * @return array
     */
    public function schemaGetItemInfo($expireAt, $videoId = '', $itemId = '')
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/schema/get_item_info/';
        // 请求体
        $data = [
            'expire_at' => $expireAt,
        ];
        if(!empty($videoId)){
            $data['video_id'] = $videoId;
        }else{
            $data['item_id'] = $itemId;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 直播间跳转链接获取
     * @access public
     * @scope jump.basic
     * @param int $expireAt
     * @param string $openId
     * @param string $account
     * @return array
     */
    public function schemaGetLive($expireAt, $openId = '', $account = '')
    {
        // 请求地址
        $url = 'https://open.douyin.com/api/douyin/v1/schema/get_live/';
        // 请求体
        $data = [
            'expire_at' => $expireAt,
        ];
        if(!empty($openId)){
            $data['open_id'] = $openId;
        }else{
            $data['account'] = $account;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 经营任务创建活动
     * @access public
     * @scope open.business.task_manage
     * @param string $activityName
     * @param array $createBusinessTaskInfoList
     * @param int $startTime
     * @param int $endTime
     * @return array
     */
    public function activityCreate($activityName, array $createBusinessTaskInfoList, $startTime, $endTime)
    {
        // 请求地址
        $url = 'https://open.douyin.com/dy_open_api/apps/v3/activity/create/';
        // 请求体
        $data = [
            'activity_name' => $activityName,
            'create_business_task_info_list' => $createBusinessTaskInfoList,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 经营任务修改活动
     * @access public
     * @scope open.business.task_manage
     * @param string $activityId
     * @param array $data
     * @return array
     */
    public function activityModify($activityId, array $data = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/dy_open_api/apps/v3/activity/modify/';
        // 请求体
        $data['activity_id'] = $activityId;
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 经营任务查询活动信息
     * @access public
     * @scope open.business.task_manage
     * @param string $activityId
     * @param array $taskIdList
     * @return array
     */
    public function activityQueryInfo($activityId, array $taskIdList = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/dy_open_api/apps/v3/activity/query_info/';
        // 请求体
        $data = [
            'activity_id' => $activityId,
        ];
        if(!empty($taskIdList)){
            $data['task_id_list'] = $taskIdList;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 经营任务查询用户是否完成
     * @access public
     * @scope open.business.task_verify
     * @param string $activityId
     * @param array $taskIdList
     * @return array
     */
    public function activityQueryActivityUserCompletionStatus($activityId, array $taskIdList = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/dy_open_api/apps/v3/activity/query_activity_user_completion_status/';
        // 请求体
        $data = [
            'activity_id' => $activityId,
        ];
        if(!empty($taskIdList)){
            $data['task_id_list'] = $taskIdList;
        }
        // 返回
        return $this->handler->callPostApi($url, $data);
    }
}