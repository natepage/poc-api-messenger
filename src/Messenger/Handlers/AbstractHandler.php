<?php
declare(strict_types=1);

namespace App\Messenger\Handlers;

use App\Services\Lock\Interfaces\LockServiceInterface;
use Closure;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

abstract class AbstractHandler implements MessageHandlerInterface
{
    /** @var \App\Services\Lock\Interfaces\LockServiceInterface */
    private $lockService;

    /**
     * @required
     *
     * Set lock service.
     *
     * @param \App\Services\Lock\Interfaces\LockServiceInterface $lockService
     *
     * @return void
     */
    public function setLockService(LockServiceInterface $lockService): void
    {
        $this->lockService = $lockService;
    }

    abstract protected function getLockResource(): string;

    /**
     * Handle message with locking to be safe.
     *
     * @param \Closure $closure
     *
     * @return mixed|void
     */
    protected function handleSafely(Closure $closure)
    {
        $lock = $this->lockService->createFactory()->createLock($this->getLockResource());

        if ($lock->acquire() === false) {
            // TODO Maybe something better to do here
            return;
        }

        try {
            $return = \call_user_func($closure);

            $lock->release();

            return $return;
        } finally {
            $lock->release();
        }
    }
}
