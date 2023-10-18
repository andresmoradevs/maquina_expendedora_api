<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Drink;

use App\Domain\Drink\Drink;
use App\Domain\Drink\DrinkNotFoundException;
use App\Infrastructure\Persistence\Drink\InMemoryDrinkRepository;
use Tests\TestCase;

class InMemoryDrinkRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $drink = new Drink(1, 'Water', 0.05);

        $drinkRepository = new InMemoryDrinkRepository([1 => $drink]);

        $this->assertEquals([$drink], $drinkRepository->findAll());
    }

    public function testFindAllDrinksByDefault()
    {
        $users = [
            1 => new Drink(1, 'Water', 0.05),
            2 => new Drink(2, 'Soda', 0.10),
            3 => new Drink(3, 'Juice', 0.25),
            4 => new Drink(4, 'Tea', 0.35),
            5 => new Drink(5, 'Coffee', 0.40),
        ];

        $drinkRepository = new InMemoryDrinkRepository();

        $this->assertEquals(array_values($drink), $drinkRepository->findAll());
    }

    public function testFindDrinkOfId()
    {
        $drink = new Drink(1, 'Water', 0.05);

        $drinkRepository = new InMemoryDrinkRepository([1 => $drink]);

        $this->assertEquals($drink, $drinkRepository->findDrinkOfId(1));
    }

    public function testFindDrinkOfIdThrowsNotFoundException()
    {
        $drinkRepository = new InMemoryDrinkRepository([]);
        $this->expectException(DrinkNotFoundException::class);
        $drinkRepository->findDrinkOfId(1);
    }
}
