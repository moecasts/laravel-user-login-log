# Laravel User Login log

## 文档

[English](https://github.com/MoeCasts/laravel-wallet)
[中文](https://www.tore.moe/post/laravel-user-login-log)

[![Build Status](https://www.travis-ci.org/MoeCasts/laravel-wallet.svg?branch=master)](https://www.travis-ci.org/MoeCasts/laravel-wallet)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MoeCasts/laravel-user-login-log/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/MoeCasts/laravel-user-login-log/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/MoeCasts/laravel-user-login-log/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/MoeCasts/laravel-user-login-log/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/MoeCasts/laravel-user-login-log/badges/build.png?b=master)](https://scrutinizer-ci.com/g/MoeCasts/laravel-user-login-log/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/MoeCasts/laravel-user-login-log/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
![Code Intelligence Status](https://img.shields.io/github/license/MoeCasts/laravel-user-login-log)

## 功能

- [x] 记录用户登录信息
- [ ] 分析登录记录

## 安装

### 依赖

- PHP 7.0+
- Laravel 5.5+

通过 `composer` 安装：

```php
composer require moecasts/laravel-user-login-log
```

如果你是用 `Laravel` 的版本 < 5.5，则需要手动将 `provide` 添加到 `config/app.php providers` 数组中

```php
Moecasts\Laravel\UserLoginLog\UserLoginLogServiceProvider,
```

发布迁移文件：

```bash
php artisan vendor:publish --tag=laravel-user-login-log-migrations
```

如果你想修改默认配置，可以运行下列命令发布配置文件后修改：

```bash
php artisan vendor:publish --tag=laravel-user-login-log-config
```

数据表迁移：

```bash
php artisan migrate
```

## 配置

```php
return [
    /**
     * 缓存时限 (seconds)
     */
    'expire' => 300,
];
```

## 用法

首先, 添加 `LoginLoggable` trait 到 authenticatable model.

```php
use Moecasts\Laravel\UserLoginLog\Traits\LoginLoggable;

class User extends Authenticatable
{
    use LoginLoggable;
}
```

然后, 在 `app/Http/Kernel.php` 中添加中间件，注意：要放在 `auth` 中间件后面。

```php
// app/Http/Kernel.php

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        // ...
        'login.log' => \Moecasts\Laravel\UserLoginLog\Middleware\UserLoginLogMiddleware::class,
    ];
    
    // ...
}
```

最后，在路由中使用：

```php
Route::get('hello')->middleware(['auth', 'login.log']);
```



### 方法

#### 获取用户登录记录

```php
$user = new User;
$user->loginLogs;
```

#### 创建用户登录记录

```php
$user = new User;
$user->createLoginLog();
```

#### 当用户重新登录时，创建登录记录

该方法依赖于缓存功能，当新登录时，会创建一个具有时限的缓存，下次请求路由时，来判断是否属于新登录。

> 实现由 `logLogin` 方法的 `$seconds` 参数控制（可留空），默认时限为配置 `loginlog.expire`。

This function is depet on cache, when your newly login, it will set a cache with for `$seconds` or default config ( `loginlog.expire` ) seconds when `$seconds`  is not set.

```php
$user = new User;
// $user->logLogin($seconds = null)
$user->logLogin();
```

#### 判断是否为新登录

```php
$user = new User;
$user->isNewLogin();
```

### Let's enjoy coding!
