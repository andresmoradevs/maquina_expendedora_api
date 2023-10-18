<?php

declare(strict_types=1);

namespace App\Domain\Drink;

use JsonSerializable;

class Drink implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private float $price;

    public function __construct(?int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = strtolower($name);
        $this->price = floatval($price);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }


    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
