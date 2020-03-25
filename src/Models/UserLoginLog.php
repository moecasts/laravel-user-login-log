<?php

namespace Moecasts\Laravel\UserLoginLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Moecasts\Laravel\UserLoginLog\DeviceType;

class UserLoginLog extends Model
{
    public $timestamps = false;

    protected $table = 'user_login_logs';

    protected $fillable = [
        'ip',
        'device',
        'platform',
        'platform_version',
        'browser',
        'browser_version',
        'device_type',
        'login_at',
    ];

    protected $casts = [
        'login_at' => 'datetime',
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getDeviceTypeAttribute($value)
    {
        return DeviceType::getType($value);
    }
}
