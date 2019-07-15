<?php

namespace Omnipay\AllPay\Test\Message;

use Omnipay\AllPay\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

/**
 * Class AuthorizeRequestTest
 * @package Omnipay\Skeleton\Message
 */
class AuthorizeRequestTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    private $options;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'merchantId' => '000000000000015',
            'transTime' => '20190710222437',
            'transactionReference' => 'abc123',
            'amount' => '10.00',
            'paymentMethod' => 'WX',
            'returnUrl' => 'https://localhost/return',
            'notifyUrl' => 'https://localhost/notify',
            'currency' => 'CNY',
            'description' => 'Test purchase 1',
            'items' => [
                [
                    'goods_name' => 'test item 1',
                    'quantity' => 1
                ],
                [
                    'goods_name' => 'test item 2',
                    'quantity' => 2
                ]
            ]
        ];
    }

    public function testSigning()
    {
        $this->request->initialize($this->options);
        $this->request->setSignature('2f2c77e3718c47cfb47a89a6fbc9d361');

        $data = $this->request->getData();

        $signature = $this->request->sign($data);

        $this->assertEquals('8dc9cfd6079beb3978b3f7daeddd0925', $signature);
    }
}