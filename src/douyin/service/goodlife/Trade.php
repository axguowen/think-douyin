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
 * 订单查询服务
 */
class Trade extends Base
{
    /**
     * 订单查询
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param int $page 页数
     * @param int $limit 页大小
     * @param array $extraData 其它参数
     * @return array
     */
    public function orderQuery($accountId, $page, $limit = 10, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/trade/order/query/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'page_num' => $page,
            'page_size' => $limit,
        ]);
        return $this->handler->callGetApi($url, $data);
    }
}