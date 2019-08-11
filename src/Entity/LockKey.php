<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="lock_keys")
 */
class LockKey
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="key_id", type="string", length=64)
     *
     * @var string
     */
    private $keyId;

    /**
     * @ORM\Column(name="key_token", type="string", length=44)
     *
     * @var string
     */
    private $keyToken;

    /**
     * @ORM\Column(name="key_expiration", type="integer", length=10, options={"unsigned"=true})
     *
     * @var int
     */
    private $keyExpiration;
}
