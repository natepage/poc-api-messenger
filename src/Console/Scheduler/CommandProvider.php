<?php
declare(strict_types=1);

namespace App\Console\Scheduler;

use LoyaltyCorp\Schedule\ScheduleBundle\Interfaces\ScheduleInterface;
use LoyaltyCorp\Schedule\ScheduleBundle\Interfaces\ScheduleProviderInterface;

final class CommandProvider implements ScheduleProviderInterface
{
    /**
     * Schedule command on given schedule.
     *
     * @param \Loyaltycorp\Schedule\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     *
     * @return void
     */
    public function schedule(ScheduleInterface $schedule): void
    {
        $schedule
            ->command('poc:hello-world', ['-v'])
            ->everyMinute()
            ->setMaxLockTime(120);

        $schedule
            ->command('poc:hello-world-2')
            ->everyFiveMinutes()
        ;
    }
}
