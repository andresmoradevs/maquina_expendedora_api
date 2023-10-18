<?php

declare(strict_types=1);

namespace App\Application\Actions\Drink;

use Psr\Http\Message\ResponseInterface as Response;

class ListDrinksAction extends DrinkAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $drinks = $this->drinkRepository->findAll();

        $this->logger->info("Drinks list was viewed.");

        return $this->respondWithData($drinks);
    }
}
