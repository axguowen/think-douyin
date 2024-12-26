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

namespace think\douyin\service\goodlife;

use think\douyin\Service;
use think\douyin\utils\Tools;

/**
 * 抖音通用公共服务
 */
class General extends Service
{
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
        $clientSecret = $this->handler->getConfig('client_secret');
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
        $clientSecret = $this->handler->getConfig('client_secret');
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
}