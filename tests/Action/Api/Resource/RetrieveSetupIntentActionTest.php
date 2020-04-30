<?php

namespace Tests\Prometee\PayumStripe\Action\Api\Resource;

use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\GatewayInterface;
use PHPUnit\Framework\TestCase;
use Prometee\PayumStripe\Action\Api\Resource\RetrieveActionInterface;
use Prometee\PayumStripe\Action\Api\Resource\RetrieveSetupIntentAction;
use Prometee\PayumStripe\Api\KeysInterface;
use Prometee\PayumStripe\Request\Api\Resource\RetrieveSetupIntent;
use Stripe\Exception\ApiErrorException;
use Stripe\SetupIntent;
use Tests\Prometee\PayumStripe\Action\Api\ApiAwareActionTestTrait;

final class RetrieveSetupIntentActionTest extends TestCase
{
    use ApiAwareActionTestTrait;

    /**
     * @test
     */
    public function shouldImplements()
    {
        $action = new RetrieveSetupIntentAction();

        $this->assertInstanceOf(ApiAwareInterface::class, $action);
        $this->assertInstanceOf(ActionInterface::class, $action);
        $this->assertNotInstanceOf(GatewayInterface::class, $action);

        $this->assertInstanceOf(RetrieveActionInterface::class, $action);
    }

    /**
     * @test
     */
    public function shouldRetrieveASetupIntent()
    {
        $model = 'si_1';

        $apiMock = $this->createApiMock();

        $action = new RetrieveSetupIntentAction();
        $action->setApiClass(KeysInterface::class);
        $action->setApi($apiMock);

        $this->assertEquals(SetupIntent::class, $action->getApiResourceClass());

        $request = new RetrieveSetupIntent($model);

        $this->assertTrue($action->supportAlso($request));

        $this->expectException(ApiErrorException::class);

        $action->execute($request);
    }
}