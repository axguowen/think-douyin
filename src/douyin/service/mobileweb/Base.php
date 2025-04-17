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
 * 抖音移动网站应用开放能力基础类
 */
abstract class Base extends Service
{
    /**
     * 接口通用GET请求方法
     * @access public
     * @param string $url 接口URL
     * @param array $query GET参数
     * @param array $headers 请求头
     * @param bool $json 是否转换为JSON参数
     * @return array
     */
    public function callGetApi($url, array $query = [], array $headers = [])
    {
        // query参数不为空
        if(!empty($query)){
            $url .= (stripos($url, '?') !== false ? '&' : '?') . http_build_query($query);
        }
        // 获取请求结果
        $response = HttpClient::get($requestUrl, $headers)->body;
        // 返回解析结果
        return $this->handler->parseResponseData($response);
    }

    /**
     * 接口通用POST请求方法
     * @access public
     * @param string $url 接口URL
     * @param array $data POST提交接口参数
     * @param array $headers 请求头
     * @param bool $json 是否转换为JSON参数
     * @return array
     */
    public function callPostApi($url, array $data = [], array $headers = [], $json = true)
    {
        // 转换为JSON
        if ($json){
            $headers['content-type'] = 'application/json';
            $data = Tools::arr2json($data);
        }
        // 获取请求结果
        $response = HttpClient::post($url, $data, $headers)->body;
        // 返回解析结果
        return $this->handler->parseResponseData($response);
    }
}