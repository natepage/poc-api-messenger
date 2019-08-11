<?php
declare(strict_types=1);

namespace App\Services\Lock;

use App\Services\Lock\Interfaces\LockServiceInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\PdoStore;

final class LockService implements LockServiceInterface
{
    /** @var \Symfony\Component\Lock\Factory */
    private $factory;

    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    /** @var \Doctrine\Common\Persistence\ManagerRegistry */
    private $registry;

    /**
     * LockService constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        $this->registry = $registry;
        $this->logger = $logger;
    }

    public function createFactory(): Factory
    {
        if ($this->factory !== null) {
            return $this->factory;
        }

        $factory = new Factory(new PdoStore($this->registry->getConnection()));
        $factory->setLogger($this->logger);

        return $this->factory = $factory;
    }
}
