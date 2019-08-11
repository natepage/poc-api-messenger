<?php
declare(strict_types=1);

namespace App\Messenger\Messages;

use App\Messenger\Interfaces\AsyncMessageInterface;

final class SimpleTextMessage implements AsyncMessageInterface
{
    /** @var string */
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
