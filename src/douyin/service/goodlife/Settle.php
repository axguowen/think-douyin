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
 * 团购对账服务
 */
class Settle extends Base
{
    /**
     * 分账明细查询
     * @access public
     * @param array $certificateIds 券码标识列表
     * @param array $extraData 其它参数
     * @return array
     */
    public function ledgerQueryRecordByCertificate(array $certificateIds, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/settle/ledger/query_record_by_cert/';
        // 请求参数
        $data = array_merge($extraData, [
            'certificate_ids' => $certificateIds,
        ]);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 离线分账单下载url
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $launchDate 分账日期
     * @return array
     */
    public function billQueryLegerUrl($accountId, $launchDate)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/settle/bill/query_leger_url/';
        // 请求参数
        $data = [
            'account_id' => $accountId,
            'launch_date' => $launchDate,
        ];
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 账单查询
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $billDate 核销日期
     * @param string $cursor 分页游标
     * @param int $size 分页大小
     * @return array
     */
    public function ledgerQuery($accountId, $billDate, $cursor = '', $size = 10)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/settle/ledger/query/';
        // 请求参数
        $data = [
            'account_id' => $accountId,
            'bill_date' => $billDate,
            'cursor' => $cursor,
            'size' => $size,
        ];
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 账单详细查询
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $billDate 核销日期
     * @param string $cursor 分页游标
     * @param int $size 分页大小
     * @return array
     */
    public function ledgerDetailedQuery($accountId, $billDate, $cursor = '', $size = 10)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/settle/ledger/detailed_query/';
        // 请求参数
        $data = [
            'account_id' => $accountId,
            'bill_date' => $billDate,
            'cursor' => $cursor,
            'size' => $size,
        ];
        return $this->handler->callGetApi($url, $data);
    }
}