TraceLog for Laravel|Lumen
===============

[![Latest Stable Version](https://img.shields.io/badge/release-v1.0.4-blue)](http://wuhuiqing@code.zm.shzhanmeng.com/ZM-Composer/trace-log.git)
[![Latest License](https://img.shields.io/badge/license-MIT-green)](http://wuhuiqing@code.zm.shzhanmeng.com/ZM-Composer/trace-log.git)
[![Latest Php](https://img.shields.io/badge/php-%5E7.2-blue)](http://wuhuiqing@code.zm.shzhanmeng.com/ZM-Composer/trace-log.git)

展盟科技基于Laravel和Lumen框架的调试日志组件.

### 安装
因组件为私有composer 所以确保在需要接入的项目中composer.json里有以下配置内容

``` json
"repositories": [
    { 
        "type": "composer",
        "url": "http://composer.shzhanmeng.com/" 
    } 
],
"config": {
        "secure-http":false
    },
```

安装组件:

```bash
$ composer require zm/trace-log
```

#### Laravel

Laravel 默认自动加载 ``` TraceLogServiceProvider::class ```

#### Lumen

使用 [Lumen](http://lumen.laravel.com), 需要添加 service provider 到 `bootstrap/app.php` 文件里. 

```php
$app->register(ZM\TraceLog\TraceLogServiceProvider::class);
```

### 配置文件
配置文件的作用在于指定个性化的日志格式标识名称

#### Laravel
在项目根目录下执行以下命令
```bash
php artisan vendor:publish --provider="ZM\TraceLog\TraceLogServiceProvider"
```

#### Lumen
复制config文件至项目的config目录中

```bash
cp vendor/zm/trace-log/config/tracelog.php config/tracelog.php
```
#### 配置说明
在 ``` tracelog.php ``` 配置文件中配置日志格式名称
```php
// tracelog.php
<?php
return [
    //填写你的laravel项目中config/logging.php配置文件里channels数组下的日志格式名称
    'channel' => null, //默认null
    //trace-id的前缀设置
    'prefix'  => 'TraceLog:'
];

// logging.php
<?php
return [
'channels' => [
        'stack' => [   //填写此名称
            'driver' => 'stack',
            'channels' => ['daily'],
        ],

        'single' => [ //填写此名称
            'driver' => 'single',
            'path' => storage_path('logs/lumen.log'),
            'level' => 'debug',
        ],

        'daily' => [  //填写此名称
            'driver' => 'daily',
            'path' => storage_path('logs/lumen.log'),
            'level' => 'debug',
            'days' => 14,
        ],
];


```
### 中间件（可选）

在Laravel | Lumen中可以添加中间件``` ZM\TraceLog\Middleware\TraceLogMiddleware::class ```
可在日志中查找到request直至response的请求返回内容，同时response的header头中有返回``` Trace-id ``` 以便日志可以根据 ``` Trace-id ```  进行查询

### 日志使用
在以上操作结束后可在代码任意地点使用日志功能

```php

function something()
{
  //打日志
  TraceLog::log('token1-1', $token);
  //如果设置了中间件trace-id为中间件生成的结果为查询依据
  TraceLog::log('token1-2', $token);
}

```