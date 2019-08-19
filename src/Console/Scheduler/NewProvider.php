<?php
declare(strict_types=1);

namespace App\Console\Scheduler;

use LoyaltyCorp\Schedule\ScheduleBundle\Interfaces\ScheduleInterface;
use LoyaltyCorp\Schedule\ScheduleBundle\Interfaces\ScheduleProviderInterface;

final class NewProvider implements ScheduleProviderInterface
{

    /**
     * Schedule command on given schedule.
     *
     * @param \LoyaltyCorp\Schedule\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     *
     * @return void
     */
    public function schedule(ScheduleInterface $schedule): void
    {
        // TODO: Implement schedule() method.
    }
}
