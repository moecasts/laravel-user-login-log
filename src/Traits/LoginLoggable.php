<?php

namespace Moecasts\Laravel\UserLoginLog\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Jenssegers\Agent\Agent;
use Moecasts\Laravel\UserLoginLog\Cacher;
use Moecasts\Laravel\UserLoginLog\DeviceType;
use Moecasts\Laravel\UserLoginLog\Models\UserLoginLog;

trait LoginLoggable
{
    public function loginLogs(): MorphMany
    {
        return $this->morphMany(UserLoginLog::class, 'loggable');
    }

    public function logLogin($seconds = null): ?UserLoginLog
    {
        $log = null;
        if ($this->isNewLogin()) {
            $log = $this->createLoginLog();
        }

        Cacher::setCache($this, $seconds);

        return $log;
    }

    public function createLoginLog(): UserLoginLog
    {
        $agent = new Agent();
        $log = new UserLoginLog([
            'ip' => request()->ip(),
            'device' => $agent->device(),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
            'device_type' => DeviceType::getValue($agent),
            'login_at' => Carbon::now(),
        ]);

        $log->platform_version = $agent->version($log->platform);
        $log->browser_version = $agent->version($log->browser);

        $this->loginLogs()->save($log);
        return $log;
    }

    public function isNewLogin(): bool
    {
        return !Cacher::hasCache($this);
    }
}
