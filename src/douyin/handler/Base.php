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

namespace think\douyin\handler;

use think\Cache;
use think\facade\App;
use think\helper\Str;
use think\douyin\utils\Tools;
use think\douyin\contract\HandlerInterface;
use axguowen\HttpClient;

/**
 * 平台句柄基础类
 */
abstract class Base implements HandlerInterface
{
	/**
     * 平台配置参数
     * @var array
     */
	protected $options = [];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = null;

    /**
     * 接口调用凭证
     * @var string
     */
    protected $clientToken = '';

    /**
     * 接口调用凭证缓存获取器
     * @var string|array
     */
    protected $clientTokenGetter = [Cache::class, 'get'];

    /**
     * 接口调用凭证缓存修改器
     * @var string|array
     */
    protected $clientTokenSetter = [Cache::class, 'set'];

    /**
     * 接口调用凭证是否无效
     * @var bool
     */
    protected $clientTokenInvalid = false;

    /**
     * 调用接口返回凭证无效的错误码
     * @var array
     */
    protected $clientTokenInvalidCode = [
        '28001008',
        '2190002',
        '2190008',
    ];

    /**
     * 架构函数
     * @access public
     * @param array $options 平台配置参数
     * @return void
     */
    public function __construct(array $options = [])
    {
        // 合并配置参数
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        // 初始化
        $this->init();
    }

	/**
     * 动态设置平台配置参数
     * @access public
     * @param array $options 平台配置
     * @return $this
     */
    public function setConfig(array $options)
    {
        // 合并配置
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        // 初始化
        $this->init();
        // 返回
        return $this;
    }

    /**
     * 获取平台配置
     * @access public
     * @param null|string $name 名称
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getConfig(string $name = null, $default = null)
    {
        // 如果未指定则获取全部
        if(empty($name)) {
            return $this->options;
        }
        // 如果存在配置
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }
        // 返回默认
        return $default;
    }

	/**
     * 初始化
     * @access protected
     * @return void
     */
    protected function init()
    {
        // 初始化缓存器
        $this->initCacheHandler();
        // 如果配置了接口调用凭证
        if (isset($this->options['client_token']) && !empty($this->options['client_token'])) {
            // 设置接口调用凭证
            $this->clientToken = $this->options['client_token'];
        }
        // 如果配置了接口调用凭证错误码
        if (isset($this->options['client_token_invalid_code']) && !empty($this->options['client_token_invalid_code'])) {
            // 设置接口调用凭证错误码
            $this->clientTokenInvalidCode = $this->options['client_token_invalid_code'];
        }
    }

	/**
     * 初始化缓存器
     * @access protected
     * @return void
     */
    protected function initCacheHandler()
    {
        // 设置默认接口调用凭证缓存获取器
        $this->clientTokenGetter = [Cache::class, 'get'];
        // 设置默认接口调用凭证缓存修改器
        $this->clientTokenSetter = [Cache::class, 'set'];
        
        // 如果配置了接口调用凭证缓存获取器
        if (isset($this->options['client_token_getter']) && !empty($this->options['client_token_getter'])) {
            // 设置接口调用凭证缓存获取器
            $this->clientTokenGetter = $this->options['client_token_getter'];
        }
        // 如果配置了接口调用凭证缓存修改器
        if (isset($this->options['client_token_setter']) && !empty($this->options['client_token_setter'])) {
            // 设置接口调用凭证缓存修改器
            $this->clientTokenSetter = $this->options['client_token_setter'];
        }
    }

    /**
     * 获取接口调用凭证
     * @access public
     * @return array
     */
    public function getClientToken()
    {
        // 当前已存在
        if (!empty($this->clientToken)) {
            return [$this->clientToken, null];
        }
        // 从缓存获取
        $this->clientToken = $this->getClientTokenFromCache();
        // 缓存存在
        if (!empty($this->clientToken)) {
            return [$this->clientToken, null];
        }
        // 在线获取
        $getClientTokenResult = $this->getClientTokenFromOnline();
        // 失败
        if(is_null($getClientTokenResult[0])){
            return $getClientTokenResult;
        }
        // 更新当前凭证
        $this->updateClientToken($getClientTokenResult[0]);
        // 返回
        return [$this->clientToken, null];
    }

    /**
     * 获取接口调用凭证缓存
     * @access protected
     * @return string
     */
    protected function getClientTokenFromCache()
    {
        // 如果是接口调用凭证已经无效
        if ($this->clientTokenInvalid) {
            return null;
        }
        // 获取缓存键名
        $cacheKey = $this->getClientTokenCacheKey();
        // 返回
        return App::invokeMethod($this->clientTokenGetter, [$cacheKey]);
    }

    /**
     * 更新当前接口调用凭证
     * @access public
     * @param array $data
     * @return $this
     */
    public function updateClientToken(array $data = [])
    {
        // 调用凭证
        $clientToken = '';
        if(!empty($data['client_token'])){
            $clientToken = $data['client_token'];
        }
        
        // 到期时间
        $expiresIn = 0;
        if(!empty($data['expires_in'])){
            // 设置调用凭证
            $expiresIn = $data['expires_in'];
        }
        // 获取缓存键名
        $cacheKey = $this->getClientTokenCacheKey();
        // 设置调用凭证
        $this->clientToken = $clientToken;
        // 调用缓存修改器方法
        App::invokeMethod($this->clientTokenSetter, [$cacheKey, $clientToken, $expiresIn]);
        // 返回
        return $this;
    }

    /**
     * 设置接口调用凭证缓存无效
     * @access protected
     * @return void
     */
    protected function invalidClientToken()
    {
        // 清空当前调用凭证
        $this->clientToken = '';
        // 设置无效状态
        $this->clientTokenInvalid = true;
    }

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
        // 获取接口调用凭证
        $getClientTokenResult = $this->getClientToken();
        // 获取接口调用凭证失败
        if(is_null($getClientTokenResult[0])){
            return $this->buildErrorMessage($getClientTokenResult);
        }
        $clientToken = $getClientTokenResult[0];
        // query参数不为空
        if(!empty($query)){
            $url .= (stripos($url, '?') !== false ? '&' : '?') . http_build_query($query);
        }
        // 请求头
        $requestHeaders = $headers;
        // 追加接口调用凭证
        $requestHeaders['access-token'] = $clientToken;
        // 获取请求结果
        $response = HttpClient::get($requestUrl, $headers)->body;
        
        // 获取解析结果
        $parseResponseDataResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseDataResult[0])){
            // 如果接口调用凭证未标记为无效，且返回码为凭证无效则重试一次
            if(false === $this->clientTokenInvalid && in_array($parseResponseDataResult[1]->getCode(), $this->clientTokenInvalidCode)){
                // 标记调用凭证无效
                $this->invalidClientToken();
                // 重试一次
                return $this->callGetApi($url, $headers);
            }
        }
        // 请求成功且当前当前调用凭证标记的是无效
        if(false !== $this->clientTokenInvalid){
            $this->clientTokenInvalid = false;
        }
        // 返回
        return $this->buildErrorMessage($parseResponseDataResult);
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
        // 获取接口调用凭证
        $getClientTokenResult = $this->getClientToken();
        // 获取接口调用凭证失败
        if(is_null($getClientTokenResult[0])){
            return $this->buildErrorMessage($getClientTokenResult);
        }
        $clientToken = $getClientTokenResult[0];
        // 请求体
        $requestData = $data;
        // 请求头
        $requestHeaders = $headers;
        // 追加接口调用凭证
        $requestHeaders['access-token'] = $clientToken;
        // 转换为JSON
        if ($json){
            $requestHeader['content-type'] = 'application/json';
            $requestData = Tools::arr2json($requestData);
        }
        // 获取请求结果
        $response = HttpClient::post($url, $requestData, $requestHeaders)->body;
        // 获取解析结果
        $parseResponseDataResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseDataResult[0])){
            // 如果接口调用凭证未标记为无效，且返回码为凭证无效则重试一次
            if(false === $this->clientTokenInvalid && in_array($parseResponseDataResult[1]->getCode(), $this->clientTokenInvalidCode)){
                // 标记调用凭证无效
                $this->invalidClientToken();
                // 重试一次
                return $this->callPostApi($url, $data, $headers, $json);
            }
        }
        // 请求成功且当前当前调用凭证标记的是无效
        if(false !== $this->clientTokenInvalid){
            $this->clientTokenInvalid = false;
        }
        // 返回
        return $this->buildErrorMessage($parseResponseDataResult);
    }

    /**
     * 解析接口响应数据
     * @access public
     * @param string $response
     * @return array
     */
    public function parseResponseData($response)
    {
        // 默认数据
        $data = [];

        try{
            // 获取转换结果
            $data = Tools::json2arr($response);
        } catch (\Exception $e) {
            return [null, $e];
        }

        // 响应数据为空
        if (empty($data)) {
            return [null, new \Exception('empty response.', '0')];
        }
        // 存在错误码
        if (!empty($data['data']['error_code'])) {
            return [null, new \Exception($data['data']['description'], $data['data']['error_code'])];
        }

        // 返回结果
        return [$data['data'], null];
    }

    /**
     * 创建服务
     * @access public
     * @param string $name
     * @return mixed
     */
    public function createService(string $name)
    {
        // 如果命名空间为空且服务名称不带命名空间
        if (empty($this->serviceNamespace) && false === strpos($name, '\\')) {
            throw new \Exception("Service [$name] not supported.");
        }
        // 获取服务类名
        $class = false !== strpos($name, '\\') ? $name : $this->serviceNamespace . Str::studly($name);
        // 服务类不存在
        if (!class_exists($class)) {
            throw new \Exception("Service [$name] class not exists.");
        }
        // 实例化服务
        return App::invokeClass($class, [$this]);
    }

    /**
     * 输出错误信息
     * @access protected
     * @param array $responseData
     * @return mixed
     */
    protected function buildErrorMessage(array $responseData)
    {
        return $responseData;
    }

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    abstract protected function getClientCacheKey();

    /**
     * 强制重新获取接口调用凭证
     * @access protected
     * @return array
     */
    abstract protected function getClientTokenFromOnline();
}