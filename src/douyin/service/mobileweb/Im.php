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
 * 即时聊天
 */
class Im extends Service
{
    /**
     * 回复私信
     * @access public
     * @param string $openId 用户的唯一标识
     * @param string $msgId
     * @param string $conversationId
     * @param string $toUserId 消息的接收方open_id
     * @param array $content
     * @return array
     */
    public function replyMsg($openId, $msgId, $conversationId, $toUserId, array $content)
    {
        // oauth凭证
        $accessToken = $this->handler->getConfig('oauth_access_token');
        // 请求体
        $data = Tools::arr2json([
            'msg_id' => $msgId,
            'conversation_id' => $conversationId,
            'to_user_id' => $toUserId,
            'content' => $content,
        ]);
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        $requestUrl = 'https://open.douyin.com/im/send/msg/?open_id=' . $openId;
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->handler->parseResponseData($response);
    }

    /**
     * 撤回私信
     * @access public
     * @param string $openId 用户的唯一标识
     * @param string $msgId
     * @param string $conversationId
     * @param string $conversationType
     * @param array $content
     * @return array
     */
    public function recallMsg($openId, $msgId, $conversationId, $conversationType)
    {
        // oauth凭证
        $accessToken = $this->handler->getConfig('oauth_access_token');
        // 请求体
        $data = Tools::arr2json([
            'msg_id' => $msgId,
            'conversation_id' => $conversationId,
            'conversation_type' => $conversationType,
        ]);
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
            'access_token' => $accessToken,
        ];
        $requestUrl = 'https://open.douyin.com/im/recall/msg/?open_id=' . $openId;
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
        // 返回结果
        return $this->handler->parseResponseData($response);
    }
}