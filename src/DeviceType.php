<?php

namespace Moecasts\Laravel\UserLoginLog;

use Jenssegers\Agent\Agent;

class DeviceType
{
    const DESKTOP = 1;
    const TABLET = 2;
    const PHONE = 3;
    const ROBOT = 4;

    public static function getType(int $value): ?String
    {
        $class = new \ReflectionClass(get_called_class());

        $constants = $class->getConstants();

        foreach ($constants as $name => $val) {
            if ($val === $value) {
                return $name;
            }
        }

        return null;
    }

    public static function getValue(Agent $agent): ?int
    {
        if ($agent->isTablet()) {
            return DeviceType::TABLET;
        } else if ($agent->isPhone()) {
            return DeviceType::PHONE;
        } elseif ($agent->isRobot()) {
            return DeviceType::ROBOT;
        } else {
            return DeviceType::DESKTOP
        }
    }
}
