<?php

declare(strict_types=1);

namespace App\Domain\Drink;

interface DrinkRepository
{
    /**
     * @return Drink[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Drink
     * @throws DrinkNotFoundException
     */
    public function findDrinkOfId(int $id): Drink;
}
