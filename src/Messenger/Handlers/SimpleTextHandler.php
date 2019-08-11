<?php
declare(strict_types=1);

namespace App\Messenger\Handlers;

use App\Messenger\Messages\SimpleTextMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

final class SimpleTextHandler extends AbstractHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __invoke(SimpleTextMessage $message)
    {
        $this->handleSafely(function () use ($message): void {
            $this->logger->debug($message->getText());
        });
    }

    protected function getLockResource(): string
    {
        return 'simple-text';
    }
}
