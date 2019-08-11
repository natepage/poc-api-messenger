<?php
declare(strict_types=1);

namespace App\Controller;

use App\Messenger\Messages\SimpleTextMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Lock\Store\PdoStore;
use Symfony\Component\Messenger\MessageBusInterface;

final class TestController extends AbstractController
{
    public function listMessages(MessageBusInterface $bus): array
    {
//        $store = new PdoStore('mysql:host=mysql;port=3306;dbname=poc', [
//            'db_username' => 'poc',
//            'db_password' => 'poc'
//        ]);
//        $store->createTable();

        $bus->dispatch(new SimpleTextMessage('my simple text'));

        $max = 15;
        $array = [];

        for ($i = 0; $i < $max; $i++) {
            $array[] = \sprintf('Message number %d', $i);
        }

        return $array;
    }

    public function createLockTable(): array
    {
        $store = new PdoStore('mysql:host=mysql;port=3306;dbname=poc', [
            'db_username' => 'poc',
            'db_password' => 'poc'
        ]);
        $store->createTable();

        return [];
    }
}
