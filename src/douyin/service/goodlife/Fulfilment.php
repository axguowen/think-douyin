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

use axguowen\HttpClient;

/**
 * 团购核销服务
 */
class Fulfilment extends Base
{
    /**
     * 验券准备
     * @access public
     * @param string $poiId 操作核销的抖音门店ID
     * @param string $code 核销码
     * @param array $extraData 其它参数
     * @return array
     */
    public function certificatePrepare($poiId, $code, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/certificate/prepare/';
        // 请求参数
        $requestData = [
            'poi_id' => $poiId,
        ];
        // 如果传入的code是短链接
        if (strpos($code, 'http') === 0) {
            // 解析短链接
            $parseEncryptedDataResult = $this->parseEncryptedData($code);
            // 如果解析失败
            if (is_null($parseEncryptedDataResult[0])) {
                // 直接返回错误信息
                return $parseEncryptedDataResult;
            }
            // 解析成功，将解析结果赋值给requestData
            $requestData['encrypted_data'] = urlencode($parseEncryptedDataResult[0]);
        }
        // 如果不是短链接
        else {
            // 直接使用code
            $requestData['code'] = $code;
        }
        // 请求参数
        $data = array_merge($extraData, $requestData);
        // 返回请求结果
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 验券
     * @access public
     * @param string $poiId 操作核销的抖音门店ID
     * @param string $verifyToken 一次验券的标识
     * @param array $extraData 其它参数
     * @return array
     */
    public function certificateVerify($poiId, $verifyToken, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/certificate/verify/';
        // 请求参数
        $data = array_merge($extraData, [
            'poi_id' => $poiId,
            'verify_token' => $verifyToken,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 撤销核销
     * @access public
     * @param string $certificateId 券码标识, 验券时返回
     * @param string $verifyId 核销的唯一标识, 验券时返回
     * @param array $extraData 其它参数
     * @return array
     */
    public function certificateCancel($certificateId, $verifyId, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/certificate/cancel/';
        // 请求参数
        $data = array_merge($extraData, [
            'certificate_id' => $certificateId,
            'verify_id' => $verifyId,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 券状态查询
     * @access public
     * @param string $encryptedCode 核销码
     * @param array $extraData 其它参数
     * @return array
     */
    public function certificateGet($encryptedCode, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/certificate/get/';
        // 请求参数
        $data = array_merge($extraData, [
            'encrypted_code' => $encryptedCode,
        ]);
        // 返回请求结果
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 券状态查询
     * @access public
     * @param string $encryptedCode 核销码
     * @param string $orderId 订单ID
     * @param array $extraData 其它参数
     * @return array
     */
    public function certificateQuery($encryptedCode = '', $orderId = '', array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/certificate/query/';
        // 请求参数
        $data = [
            'encrypted_code' => $encryptedCode,
        ];
        // 如果传入了orderId
        if (!empty($orderId)) {
            $data = [
                'order_id' => $orderId,
            ];
        }
        // 请求参数
        $data = array_merge($extraData, $data);
        // 返回请求结果
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 跨订单验券
     * @access public
     * @param string $poiId 操作核销的抖音门店ID
     * @param array $certificateBatchVerifyList 验券的标识列表
     * @return array
     */
    public function certificateBatchVerify($poiId, array $certificateBatchVerifyList)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/certificate/batch_verify/';
        // 请求参数
        $data = [
            'poi_id' => $poiId,
            'certificate_batch_verify_list' => $certificateBatchVerifyList,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 发券回调
     * @access public
     * @param string $orderId 订单ID
     * @param int $result 发券结果，1=成功，2=失败
     * @param array $extraData 其它参数
     * @return array
     */
    public function createCallback($orderId, $result, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/create/callback/';
        // 请求参数
        $data = array_merge($extraData, [
            'order_id' => $orderId,
            'result' => $result,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 审核回调
     * @access public
     * @param array $certificate 抖音内部券码信息列表
     * @param int $result 审核结果，1=允许，2=拒绝
     * @param array $extraData 其它参数
     * @return array
     */
    public function refundAudit(array $certificate, $result, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/refund/audit/';
        // 请求参数
        $data = array_merge($extraData, [
            'certificate' => $certificate,
            'result' => $result,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 验券历史查询
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $cursor 分页游标，从0开始递增
     * @param int $size 页大小
     * @param array $extraData 其它参数
     * @return array
     */
    public function certificateVerifyRecordQuery($accountId, $cursor, $size = 10, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/fulfilment/certificate/verify_record/query/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'cursor' => $cursor,
            'size' => $size,
        ]);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 解析短链接encrypted_data
     * @access protected
     * @param string $url 核销码短链接URL
     * @return array
     */
    protected function parseEncryptedData($url)
    {
        // 对短连接进行HTTP请求
        $response = HttpClient::get($url, [], 3);
        // 如果不是302重定向，直接返回错误信息
        if ($response->statusCode() !== 302) {
            return [null, new \Exception('核销码短链接解析失败，响应状态码不是302')];
        }
        // 获取响应头
        $headers = $response->headers();
        // 如果Location头不存在，直接返回错误信息
        if (!isset($headers['Location']) || empty($headers['Location'])) {
            return [null, new \Exception('核销码短链接解析失败，Location头不存在')];
        }
        // 解析Location的query参数
        $query = parse_url($headers['Location'], PHP_URL_QUERY);
        // 解析query参数
        $params = [];
        parse_str($query, $params);
        // 如果object_id不存在，直接返回错误信息
        if (!isset($params['object_id']) || empty($params['object_id'])) {
            return [null, new \Exception('核销码短链接解析失败，object_id参数不存在')];
        }
        // 解析成功，返回解析结果
        return [$params['object_id'], null];
    }
}