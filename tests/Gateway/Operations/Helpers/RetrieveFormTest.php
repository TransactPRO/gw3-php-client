<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Helpers;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use TransactPro\Gateway\Exceptions\RequestException;
use TransactPro\Gateway\Responses\Parts\Payment\GW;
use TransactPro\Gateway\Responses\PaymentResponse;
use TransactPro\Gateway\Validator\Validator;

class RetrieveFormTest extends TestCase
{
    /**
     * @throws ReflectionException
     * @throws RequestException
     */
    public function testConstructorSuccessful(): void
    {
        $paymentResponse = new PaymentResponse(null);
        $paymentResponse->gw = new GW(['redirect-url' => 'qwerty']);

        $instance = new RetrieveForm(new Validator(), $paymentResponse);
        $this->assertEquals('GET', $this->getPrivatePropertyValue($instance, 'method'));
        $this->assertEquals('qwerty', $this->getPrivatePropertyValue($instance, 'path'));
    }

    public function testConstructorFailure(): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage("Response doesn't contain link to an HTML form");

        new RetrieveForm(new Validator(), new PaymentResponse([]));
    }

    /**
     * @param RetrieveForm $object
     * @param string       $propertyName
     *
     * @throws ReflectionException
     * @return mixed
     */
    protected function getPrivatePropertyValue(RetrieveForm $object, string $propertyName)
    {
        $rc = new ReflectionClass($object);
        $property = $rc->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
