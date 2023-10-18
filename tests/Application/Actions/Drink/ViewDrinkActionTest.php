<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Drink;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\Drink\Drink;
use App\Domain\Drink\DrinkNotFoundException;
use App\Domain\Drink\DrinkRepository;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewDrinkActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $drink = new Drink(1, 'Water', 0.05);

        $drinkRepositoryProphecy = $this->prophesize(DrinkRepository::class);
        $drinkRepositoryProphecy
            ->findDrinkOfId(1)
            ->willReturn($drink)
            ->shouldBeCalledOnce();

        $container->set(DrinkRepository::class, $drinkRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/drinks/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $drink);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsDrinkNotFoundException()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $drinkRepositoryProphecy = $this->prophesize(DrinkRepository::class);
        $drinkRepositoryProphecy
            ->findDrinkOfId(1)
            ->willThrow(new DrinkNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(DrinkRepository::class, $drinkRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/drinks/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The drink you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
