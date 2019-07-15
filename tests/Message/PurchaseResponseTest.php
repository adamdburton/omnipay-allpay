<?php

namespace Omnipay\AllPay\Test\Message;

use Omnipay\AllPay\Gateway;
use Omnipay\AllPay\Message\PurchaseRequest;
use Omnipay\AllPay\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

/**
 * Class PurchaseRequestTest
 * @package Omnipay\Skeleton\Message
 */
class PurchaseResponseTest extends TestCase
{
    private $gateway;
    private $options;

    protected function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'merchantId' => '000000000000015',
            'signature' => '2f2c77e3718c47cfb47a89a6fbc9d361',
            'transactionReference' => 'abc123',
            'amount' => '10.00',
            'returnUrl' => 'https://localhost/return',
            'notifyUrl' => 'https://localhost/notify',
            'currency' => 'CNY',
            'paymentMethod' => 'WX',
            'description' => 'Test purchase 3',
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

    public function testPurchaseResponse()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->options)->send();
//var_dump($response);die();
        $this->assertTrue(strpos($response->getMessage(), 'allpay_form') !== -1);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
    }

    public function testRedirect()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->expectOutputRegex('/Redirecting to payment page\.\.\./');
        $response->redirect();
    }
}