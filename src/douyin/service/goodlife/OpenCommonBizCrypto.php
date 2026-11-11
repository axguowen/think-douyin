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

/**
 * 开放通用业务加密服务
 */
class OpenCommonBizCrypto extends Base
{
    /**
     * 开放平台解密脱敏
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param array $cipherTexts 待解密的文本列表
     * @return array
     */
    public function decryptMaskBatch($accountId, array $cipherTexts)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/open/common_biz/crypto/decrypt_mask/batch/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'cipher_texts' => $cipherTexts,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 开放平台解密
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param array $cipherTexts 待解密的文本列表
     * @return array
     */
    public function decryptBatch($accountId, array $cipherTexts)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/open/common_biz/crypto/decrypt/batch/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'cipher_texts' => $cipherTexts,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 开放平台加密
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param array $plainTexts 待加密的文本列表
     * @return array
     */
    public function encryptBatch($accountId, array $plainTexts)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/open/common_biz/crypto/encrypt/batch/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'plain_texts' => $plainTexts,
        ]);
        return $this->handler->callPostApi($url, $data);
    }
}