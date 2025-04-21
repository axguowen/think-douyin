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
 * 私信群聊能力
 */
class Im extends Base
{
    /**
     * 发送私信
     * @access public
     * @scope im.direct_message
     * @param string $accessToken oauth授权用户的access_token
     * @param string $openId 用户唯一标识
     * @param string $toUserId 消息的接收方open_id
     * @param string $msgId
     * @param string $conversationId
     * @param array $content
     * @param string $scene
     * @return array
     */
    public function sendMsg($accessToken, $openId, $toUserId, $msgId, $conversationId, array $content, $scene = '')
    {
        // 请求地址
        $url = 'https://open.douyin.com/im/send/msg/?open_id=' . $openId;
        // 如果场景值为空
        if(empty($scene)) {
            $scene = 'im_reply_msg';
        }
        // 请求体
        $data = [
            'msg_id' => $msgId,
            'conversation_id' => $conversationId,
            'to_user_id' => $toUserId,
            'content' => $content,
            'scene' => $scene,
        ];
        // 请求头
        $header = [
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callPostApi($url, $data, $header);
    }

    /**
     * 撤回私信
     * @access public
     * @scope im.recall_message
     * @param string $accessToken oauth授权用户的access_token
     * @param string $openId 用户唯一标识
     * @param string $msgId
     * @param string $conversationId
     * @param string $conversationType
     * @return array
     */
    public function recallMsg($accessToken, $openId, $msgId, $conversationId, $conversationType = 1)
    {
        // 请求地址
        $url = 'https://open.douyin.com/im/recall/msg/?open_id=' . $openId;
        // 请求体
        $data = [
            'msg_id' => $msgId,
            'conversation_id' => $conversationId,
            'conversation_type' => $conversationType,
        ];
        // 请求头
        $header = [
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callPostApi($url, $data, $header);
    }

    /**
     * 查询授权主动私信用户
     * @access public
     * @scope im.direct_message
     * @param string $accessToken oauth授权用户的access_token
     * @param string $openId 用户唯一标识
     * @param int $pageNum
     * @param int $pageSize
     * @return array
     */
    public function authorizeUserList($accessToken, $openId, $pageNum, $pageSize = 10)
    {
        // 请求地址
        $url = 'https://open.douyin.com/im/authorize/user_list/?open_id=' . $openId;
        // 请求体
        $data = [
            'page_num' => $pageNum,
            'page_size' => $pageSize,
        ];
        // 请求头
        $header = [
            'access_token' => $accessToken,
        ];
        // 返回
        return $this->callPostApi($url, $data, $header);
    }
}