<?php

declare(strict_types=1);

namespace Tests\Domain\Drink;

use App\Domain\User\Drink;
use Tests\TestCase;

class DrinkTest extends TestCase
{
    public function drinkProvider(): array
    {
        return [
            [1, 'Water', 0.05],
            [2, 'Soda', 0.10],
            [3, 'Juice', 0.25],
            [4, 'Tea', 0.35],
            [5, 'Coffee', 0.40],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $name
     * @param floatval $price
     */
    public function testGetters(int $id, string $name, floatval $price)
    {
        $drink = new Drink($id, $name, $price);

        $this->assertEquals($id, $drink->getId());
        $this->assertEquals($name, $drink->getName());
        $this->assertEquals($price, $drink->getPrice());
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $name
     * @param floatval $price
     */
    public function testJsonSerialize(int $id, string $name, floatval $price)
    {
        $user = new Drink($id, $name, $price);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'price' => $price
        ]);

        $this->assertEquals($expectedPayload, json_encode($drink));
    }
}
