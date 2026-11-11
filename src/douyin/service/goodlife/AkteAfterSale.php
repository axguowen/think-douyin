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
 * 售后退款服务
 */
class AkteAfterSale extends Base
{
    /**
     * 售后单详情查询
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $orderId 订单ID
     * @param array $extraData 其它参数
     * @return array
     */
    public function orderDetail($accountId, $orderId, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/akte/after_sale/order_detail/get/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'order_id' => $orderId,
        ]);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 订单查询
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param int $limit 页大小
     * @param array $extraData 其它参数
     * @return array
     */
    public function orderQuery($accountId, $limit = 10, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/trade/order/query/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'page_size' => $limit,
        ]);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 抖音码核销后退款审批
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $orderId 订单ID
     * @param string $certificateId 抖音内部券码ID
     * @param boolean $auditStatus 审核状态，true=允许，false=拒绝
     * @param array $extraData 其它参数
     * @return array
     */
    public function refundAudit($accountId, $orderId, $certificateId, $auditStatus, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/akte/after_sale/order/audit/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'order_id' => $orderId,
            'certificate_id' => $certificateId,
            'audit_status' => $auditStatus,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 发起退款
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $orderId 订单ID
     * @param string $refundReasonCode 退款原因编码
     * @param array $extraData 其它参数
     * @return array
     */
    public function refundApply($accountId, $orderId, $refundReasonCode, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/groupon/order/refund/apply/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'order_id' => $orderId,
            'refund_reason_code' => $refundReasonCode,
        ]);
        return $this->handler->callPostApi($url, $data);
    }
}