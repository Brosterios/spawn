<?php declare(strict_types=1);

namespace spawn\system\Throwables;

use spawn\system\Throwables\AbstractException;

class HeadersSendByException extends AbstractException
{

    protected function getMessageTemplate(): string
    {
        return 'The headers were already send by!';
    }

    protected function getExitCode(): int
    {
        return 51;
    }
}