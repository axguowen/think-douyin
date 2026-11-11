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
 * 商品服务
 */
class Goods extends Base
{
    /**
     * 更新标品适用门店
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param array $poiIdList 门店POID列表
     * @param array $poiOperateType 操作类型
     * @param array $extraData 其它参数
     * @return array
     */
    public function spuPoiOperate($accountId, array $poiIdList, array $poiOperateType, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v2/goods/spu/poi/operate/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'poi_id_list' => $poiIdList,
            'poi_operate_type' => $poiOperateType,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 创建/更新商品
     * @access public
     * @param array $product 商品信息
     * @param array $extraData 其它参数
     * @return array
     */
    public function productSave(array $product, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/save/';
        // 请求参数
        $data = array_merge($extraData, [
            'product' => $product,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 创建/更新商品
     * @access public
     * @param int $opType 操作类型1:上架 2:下架 3:删除商品
     * @param array $extraData 其它参数
     * @return array
     */
    public function productOperate($opType, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/operate/';
        // 请求参数
        $data = array_merge($extraData, [
            'op_type' => $opType,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 免审修改商品
     * @access public
     * @param array $options 参数
     * @return array
     */
    public function productFreeAudit(array $options = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/operate/';
        return $this->handler->callPostApi($url, $options);
    }

    /**
     * 同步库存
     * @access public
     * @param array $stock 库存信息
     * @param array $extraData 其它参数
     * @return array
     */
    public function stockSync(array $stock, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/stock/sync/';
        // 请求参数
        $data = array_merge($extraData, [
            'stock' => $stock,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 创建/更新多SKU商品的SKU列表
     * @access public
     * @param array $skus 信息
     * @param array $extraData 其它参数
     * @return array
     */
    public function skuBatchSave(array $skus, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/sku/batchSave/';
        // 请求参数
        $data = array_merge($extraData, [
            'skus' => $skus,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询商品品类
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param int $categoryId 行业类目ID
     * @param int $queryCategoryType 查询类型: 0-返回单层结构子类目信息, 1-返回树形结构子类目信息
     * @return array
     */
    public function categoryGet($accountId = '', $categoryId = 0, $queryCategoryType = 0)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/category/get/';
        // 请求参数
        $data = [
            'query_category_type' => $queryCategoryType,
        ];
        // 如果有行业类目ID，添加到参数
        if (!empty($categoryId)) {
            $data['category_id'] = $categoryId;
        }
        // 如果有来客商户根账户ID，添加到参数
        if (!empty($accountId)) {
            $data['account_id'] = $accountId;
        }
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 查询商品草稿数据列表
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $cursor 分页游标，从0开始递增
     * @param int $count 分页数量
     * @param int $status 过滤草稿状态，10-审核中 12-审核失败 1-审核通过
     * @return array
     */
    public function productDraftQuery($accountId = '', $cursor = '', $count = 20, $status = 0)
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/draft/query/';
        // 请求参数
        $data = [
            'count' => $count,
        ];
        // 如果有来客商户根账户ID，添加到参数
        if (!empty($accountId)) {
            $data['account_id'] = $accountId;
        }
        // 如果有分页游标，添加到参数
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        // 如果有状态参数，添加到参数
        if (!empty($status)) {
            $data['status'] = $status;
        }
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 查询商品草稿数据
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param array $extraData 其它参数
     * @return array
     */
    public function productDraftGet($accountId, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/draft/get/';
        // 请求参数
        $data = [
            'account_id' => $accountId,
        ];
        $data = array_merge($extraData, $data);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 查询商品线上数据列表
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $cursor 分页游标，从0开始递增
     * @param int $count 分页数量
     * @param int $status 1-在线 2-下线 3-封禁
     * @param array $extraData 其它参数
     * @return array
     */
    public function productOnlineQuery($accountId, $cursor = '', $count = 20, $status = 0, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/online/query/';
        // 请求参数
        $data = [
            'count' => $count,
        ];
        // 如果有来客商户根账户ID，添加到参数
        if (!empty($accountId)) {
            $data['account_id'] = $accountId;
        }
        // 如果有分页游标，添加到参数
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        // 如果有状态参数，添加到参数
        if (!empty($status)) {
            $data['status'] = $status;
        }
        $data = array_merge($extraData, $data);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 查询商品线上数据
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param array $extraData 其它参数
     * @return array
     */
    public function productOnlineGet($accountId = '', array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/online/get/';
        // 请求参数
        $data = [];
        // 如果有来客商户根账户ID，添加到参数
        if (!empty($accountId)) {
            $data['account_id'] = $accountId;
        }
        $data = array_merge($extraData, $data);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 查询商品模板数据
     * @access public
     * @param string $categoryId 行业类目ID
     * @param int $productType 商品类型
     * @param array $extraData 其它参数
     * @return array
     */
    public function productTemplateGet($categoryId, $productType, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/template/get/';
        // 请求参数
        $data = array_merge($extraData, [
            'category_id' => $categoryId,
            'product_type' => $productType,
        ]);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 批量查询sku
     * @access public
     * @param string $productOutId 商品外部ID
     * @param array $extraData 其它参数
     * @return array
     */
    public function skuGet($productOutId, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/sku/get/';
        // 请求参数
        $data = array_merge($extraData, [
            'product_out_id' => $productOutId,
        ]);
        return $this->handler->callGetApi($url, $data);
    }

    /**
     * 分时代金券金额查询
     * @access public
     * @param string $accountId 来客商户根账户ID
     * @param string $orderId 订单ID
     * @param int $orderCreateTime 订单创建时间
     * @param array $extraData 其它参数
     * @return array
     */
    public function productCouponPriceQuery($accountId,$orderId, $orderCreateTime, array $extraData = [])
    {
        // 请求地址
        $url = 'https://open.douyin.com/goodlife/v1/goods/product/coupon_price/query/';
        // 请求参数
        $data = array_merge($extraData, [
            'account_id' => $accountId,
            'order_id' => $orderId,
            'order_create_time' => $orderCreateTime,
        ]);
        return $this->handler->callGetApi($url, $data);
    }
}