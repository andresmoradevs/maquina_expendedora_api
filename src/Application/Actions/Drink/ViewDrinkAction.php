<?php

declare(strict_types=1);

namespace App\Application\Actions\Drink;

use Psr\Http\Message\ResponseInterface as Response;

class ViewDrinkAction extends DrinkAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $drinkId = (int) $this->resolveArg('id');
        $drink = $this->drinkRepository->findDrinkOfId($drinkId);

        $this->logger->info("Drink of id `${drinkId}` was viewed.");

        return $this->respondWithData($drink);
    }
}
