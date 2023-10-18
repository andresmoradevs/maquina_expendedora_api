<?php

declare(strict_types=1);

namespace App\Application\Actions\Drink;

use App\Application\Actions\Action;
use App\Domain\Drink\DrinkRepository;
use Psr\Log\LoggerInterface;

abstract class DrinkAction extends Action
{
    protected DrinkRepository $drinkRepository;

    public function __construct(LoggerInterface $logger, DrinkRepository $drinkRepository)
    {
        parent::__construct($logger);
        $this->drinkRepository = $drinkRepository;
    }
}
