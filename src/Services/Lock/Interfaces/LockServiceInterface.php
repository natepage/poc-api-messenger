<?php
declare(strict_types=1);

namespace App\Services\Lock\Interfaces;

use Symfony\Component\Lock\Factory;

interface LockServiceInterface
{
    public function createFactory(): Factory;
}
