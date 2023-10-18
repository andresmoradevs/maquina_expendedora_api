<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Drink;

use App\Application\Actions\ActionPayload;
use App\Domain\Drink\DrinkRepository;
use App\Domain\Drink\Drink;
use DI\Container;
use Tests\TestCase;

class ListDrinkActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $drink = new Drink(1, 'Water', 0.05);

        $drinkRepositoryProphecy = $this->prophesize(DrinkRepository::class);
        $drinkRepositoryProphecy
            ->findAll()
            ->willReturn([$drink])
            ->shouldBeCalledOnce();

        $container->set(DrinkRepository::class, $drinkRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/drinks');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$drink]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
