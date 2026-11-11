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
 * 门店相关服务
 */
class Poi extends Base
{
    /**
     * 创建适用人群
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $poiId 门店ID
     * @param array $crowds 适用人群
     * @param array $extraData 其它参数
     * @return array
     */
    public function crowdSave($accountId, $poiId, $crowds, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/crowd/save/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'poi_id' => $poiId,
            'crowds' => $crowds,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询门店任务结果
     * @access public
     * @param array $taskIds 任务ID列表
     * @return array
     */
    public function taskQuery(array $taskIds = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/task/query/';
        return $this->handler->callGetApi($url, [
            'task_ids' => $taskIds,
        ]);
    }

    /**
     * 提交门店基础信息更新任务
     * @access public
     * @param array $datas 其它参数
     * @return array
     */
    public function poiUpdate(array $datas = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/poi/update/';
        return $this->handler->callPostApi($url, [
            'datas' => $datas,
        ]);
    }

    /**
     * 提交门店资质亮照/修改任务
     * @access public
     * @param array $datas 其它参数
     * @param int $targetType 目标类型
     * @return array
     */
    public function poiClaim(array $datas = [], $targetType = 0)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/poi/claim/';
        return $this->handler->callPostApi($url, [
            'datas' => $datas,
            'target_type' => $targetType,
        ]);
    }

    /**
     * 查询门店信息
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $poiId 门店ID
     * @param int $page 页码
     * @param int $size 每页数量
     * @param array $extraData 其它参数
     * @return array
     */
    public function shopQuery($accountId = '', $poiId = '', $page = 1, $size = 10, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/shop/poi/query/';
        // 请求参数
        $data = [
            'page' => $page,
            'size' => $size,
        ];
        // 如果有来客商户根账户ID，添加到参数
        if (!empty($accountId)) {
            $data['account_id'] = $accountId;
        }
        // 如果有门店ID，添加到参数
        if (!empty($poiId)) {
            $data['poi_id'] = $poiId;
        }
        // 合并额外参数
        $data = array_merge($extraData, $data);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 查询门店资质信息
     * @access public
     * @param string $merchantLifeAccountId 商家总户ID
     * @param string $poiId 门店ID
     * @return array
     */
    public function certInfo($merchantLifeAccountId = '', $poiId = '')
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/cert/info/';
        // 请求参数
        $data = [];
        // 如果有商家总户ID，添加到参数
        if (!empty($merchantLifeAccountId)) {
            $data['merchant_life_account_id'] = $merchantLifeAccountId;
        }
        // 如果有门店ID，添加到参数
        if (!empty($poiId)) {
            $data['poi_id'] = $poiId;
        }
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 查询门店匹配关系
     * @access public
     * @param array $extIds 三方门店id列表
     * @return array
     */
    public function matchRelationQuery(array $extIds = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/match/relation/query/';
        // 请求参数
        $data = [
            'ext_ids' => $extIds,
        ];
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 提交门店匹配任务
     * @access public
     * @param array $datas 任务列表
     * @return array
     */
    public function matchTaskSubmit(array $datas = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/match/task/submit/';
        return $this->handler->callPostApi($url, [
            'datas' => $datas,
        ]);
    }

    /**
     * 查询门店匹配任务结果
     * @access public
     * @param string $taskId 任务ID
     * @return array
     */
    public function matchTaskQuery($taskId)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/poi/match/task/query/';
        // 请求参数
        $data = [
            'task_id' => $taskId,
        ];
        return $this->handler->callGetApi($url, $data);
    }
}