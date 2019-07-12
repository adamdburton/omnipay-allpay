<?php

namespace Omnipay\Skeleton\Message;

use Omnipay\AllPay\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testSigning()
    {
        $options = [
            'merchantId' => '000000000000015',
            'transactionReference' => 'abc123',
            'amount' => '10.00',
            'paymentMethod' => 'WX',
            'returnUrl' => 'https://localhost/return',
            'notifyUrl' => 'https://localhost/notify',
            'currency' => 'CNY',
            'description' => 'Test purchase',
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

        $this->request->initialize($options);
        $this->request->setTransTime('20190710222437');
        $this->request->setSignature('2f2c77e3718c47cfb47a89a6fbc9d361');

        $data = $this->request->getData();

        $this->assertEquals(strtolower('88d2fbc9291ff38d711016172ef28981'), $this->request->sign($data));
    }
}