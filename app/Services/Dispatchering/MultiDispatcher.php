<?php

namespace App\Services\Dispatchering;

interface MultiDispatcher
{
    public function multiDispatch(array $events);
}
