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

return [
    // 默认平台
    'default' => 'goodlife',
    // 平台配置
    'platforms' => [
        // 生活服务商家应用
        'goodlife' => [
            // 驱动类型
            'type' => 'Goodlife',
            // 应用ID
            'app_key' => '',
            // 应用密钥
            'app_secret' => '',
        ],
        // 移动网站应用
        'mobileweb' => [
            // 驱动类型
            'type' => 'Mobileweb',
            // 应用ID
            'client_key' => '',
            // 应用密钥
            'client_secret' => '',
        ],
    ],
];
