<?php

namespace Omnipay\AllPay\Test\Message;

use Omnipay\AllPay\Message\PurchaseRequest;
use Omnipay\AllPay\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

/**
 * Class PurchaseRequestTest
 * @package Omnipay\Skeleton\Message
 */
class PurchaseRequestTest extends TestCase
{
//    public function test

    public function testMethods()
    {
        $options = [
            'merchantId' => '000000000000015',
            'transactionReference' => 'abc123',
            'amount' => '10.00',
            'paymentMethod' => 'WX',
            'returnUrl' => 'https://localhost/return',
            'notifyUrl' => 'https://localhost/notify',
            'currency' => 'CNY',
            'description' => 'Test purchase 4',
            'transTime' => date('YmdHis'),
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

        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($options);
        $data = $request->getData();

        $this->assertEquals($data['tradeFrom'], 'QUICK');

        $options['paymentMethod'] = 'AP';

        $request->initialize($options);
        $data = $request->getData();

        $this->assertEquals($data['tradeFrom'], 'WEB');

        $options['paymentMethod'] = 'UP';

        $request->initialize($options);
        $data = $request->getData();

        $this->assertEquals($data['tradeFrom'], 'H5');
    }
}