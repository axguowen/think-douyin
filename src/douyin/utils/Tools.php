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

namespace think\douyin\utils;

/**
 * 工具类
 */
class Tools
{
    /**
     * 产生随机字符串
     * @access public
     * @param int $length 指定字符长度
     * @param string $str 字符串前缀
     * @return string
     */
    public static function createNoncestr($length = 32, $str = '')
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 获取输入对象
     * @access public
     * @return false|mixed|string
     */
    public static function getRawInput()
    {
        if (empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
            return file_get_contents('php://input');
        } else {
            return $GLOBALS['HTTP_RAW_POST_DATA'];
        }
    }

    /**
     * 数组转XML内容
     * @access public
     * @param array $data
     * @return string
     */
    public static function arr2xml($data)
    {
        return '<xml>' . static::arr2xmlField($data) . '</xml>';
    }

    /**
     * XML内容生成
     * @access protected
     * @param array $data 数据
     * @param string $content
     * @return string
     */
    protected static function arr2xmlField($data, $content = '')
    {
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = 'item';
            $content .= "<{$key}>";
            if (is_array($val) || is_object($val)) {
                $content .= static::arr2xmlField($val);
            } elseif (is_string($val)) {
                $content .= '<![CDATA[' . preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $val) . ']]>';
            } else {
                $content .= $val;
            }
            $content .= "</{$key}>";
        }
        return $content;
    }

    /**
     * 解析XML内容到数组
     * @access public
     * @param string $xml
     * @return array
     */
    public static function xml2arr($xml)
    {
        if (PHP_VERSION_ID < 80000) {
            $backup = libxml_disable_entity_loader(true);
            $data = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            libxml_disable_entity_loader($backup);
        } else {
            $data = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        return json_decode(json_encode($data), true);
    }

    /**
     * 解析XML文本内容
     * @access public
     * @param string $xml
     * @return array|false
     */
    public static function xml3arr($xml)
    {
        $state = xml_parse($parser = xml_parser_create(), $xml, true);
        return xml_parser_free($parser) && $state ? static::xml2arr($xml) : false;
    }

    /**
     * 数组转xml内容
     * @access public
     * @param array $data
     * @return null|string
     */
    public static function arr2json($data)
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $json === '[]' ? '{}' : $json;
    }

    /**
     * 解析JSON内容到数组
     * @access public
     * @param string $json
     * @return array
     * @throws \Exception
     */
    public static function json2arr($json)
    {
        // 转换成数组
        $result = json_decode($json, true);
        // 转换失败
        if (!is_array($result)) {
            throw new \Exception('invalid json string.', '0');
        }
        // 返回
        return $result;
    }

    /**
     * 数组对象Emoji编译处理
     * @access public
     * @param array $data
     * @return array
     */
    public static function buildEnEmojiData(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = static::buildEnEmojiData($value);
            } elseif (is_string($value)) {
                $data[$key] = static::emojiEncode($value);
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * 数组对象Emoji反解析处理
     * @access public
     * @param array $data
     * @return array
     */
    public static function buildDeEmojiData(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = static::buildDeEmojiData($value);
            } elseif (is_string($value)) {
                $data[$key] = static::emojiDecode($value);
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * Emoji原形转换为String
     * @access public
     * @param string $content
     * @return string
     */
    public static function emojiEncode($content)
    {
        return json_decode(preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function ($string) {
            return addslashes($string[0]);
        }, json_encode($content)));
    }

    /**
     * Emoji字符串转换为原形
     * @access public
     * @param string $content
     * @return string
     */
    public static function emojiDecode($content)
    {
        return json_decode(preg_replace_callback('/\\\\\\\\/i', function () {
            return '\\';
        }, json_encode($content)));
    }

    /**
     * 签名生成
     * @access public
     * @param string $clientSecret
     * @param string $httpBody
     * @return string
     */
    public static function sign($clientSecret, $httpBody)
    {
        // 返回sha1值
        return hash('sha1', $clientSecret . $httpBody);
    }

    /**
     * SPI签名生成
     * @access public
     * @param string $clientSecret
     * @param array $httpQuery
     * @param string $httpBody
     * @return string
     */
    public static function spiSign($clientSecret, array $httpQuery = [], $httpBody = '')
    {
        // 签名字符串
        $signStr = $clientSecret;
        // 如果query参数存在sign
        if (isset($httpQuery['sign'])) {
            unset($httpQuery['sign']);
        }
        // 如果query参数不为空
        if(!empty($httpQuery)) {
            // 按字典升序排序
            ksort($httpQuery);
            // 拼接参数
            $signStr .= '&' . http_build_query($httpQuery);
        }
        // 如果body参数不为空
        if(!empty($httpBody)) {
            // 拼接参数
            $signStr .= '&http_body=' . $httpBody;
        }
        // 返回sha256值
        return hash('sha256', $signStr);
    }
}
