<?php
declare(strict_types=1);

namespace App\Resource;

use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get_messages"={
 *              "method"="GET",
 *              "path"="/test/getMessages",
 *              "controller"="\App\Controller\TestController::listMessages",
 *          }
 *     },
 *     itemOperations={}
 * )
 */
final class TestResource
{
    /** @var string */
    public $bullshit;
}
