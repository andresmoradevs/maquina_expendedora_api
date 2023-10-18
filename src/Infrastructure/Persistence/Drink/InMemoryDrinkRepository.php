<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Drink;

use App\Domain\Drink\Drink;
use App\Domain\Drink\DrinkNotFoundException;
use App\Domain\Drink\DrinkRepository;

class InMemoryDrinkRepository implements DrinkRepository
{
    /**
     * @var Drink[]
     */
    private array $drinks;

    /**
     * @param Drink[]|null $drinks
     */
    public function __construct(array $drinks = null)
    {
        $this->drinks = $drinks ?? [
            1 => new Drink(1, 'Water', 0.05),
            2 => new Drink(2, 'Soda', 0.10),
            3 => new Drink(3, 'Juice', 0.25),
            4 => new Drink(4, 'Tea', 0.35),
            5 => new Drink(5, 'Coffee', 0.40),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->drinks);
    }

    /**
     * {@inheritdoc}
     */
    public function findDrinkOfId(int $id): Drink
    {
        if (!isset($this->drinks[$id])) {
            throw new DrinkNotFoundException();
        }

        return $this->drinks[$id];
    }
}
