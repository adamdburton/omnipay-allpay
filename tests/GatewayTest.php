<?php

namespace Omnipay\AllPay\Test;

use Omnipay\AllPay\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    protected $gateway;

    private $purchaseOptions;
    private $refundOptions;
    private $completePurchaseOptions;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->purchaseOptions = [
            'merchantId' => '000000000000015',
            'signature' => '2f2c77e3718c47cfb47a89a6fbc9d361',
            'transactionReference' => 'abc123',
            'amount' => '10.00',
            'returnUrl' => 'https://localhost/return',
            'notifyUrl' => 'https://localhost/notify',
            'currency' => 'CNY',
            'paymentMethod' => 'WX',
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

        $this->refundOptions = [
            'merchantId' => '000000000000015',
            'signature' => '2f2c77e3718c47cfb47a89a6fbc9d361',
            'transactionReference' => 'abc123',
            'originalOrderNumber' => 'abc123',
            'amount' => '10.00',
            'currency' => 'CNY',
            'paymentMethod' => 'WX'
        ];

        $this->completePurchaseOptions = [
            'transactionReference' => 'abc123',
            'paymentMethod' => 'UP'
        ];
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('https://101.231.204.80:5000/gateway/api/frontTransReq.do', $response->getRedirectUrl());
    }

    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->gateway->purchase($this->purchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
    }

    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $response = $this->gateway->refund($this->refundOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('f332f23f23f23f', $response->getTransactionReference());
    }

    public function testRefundFailure()
    {
        $this->setMockHttpResponse('RefundFailure.txt');
        $response = $this->gateway->refund($this->refundOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
    }

    public function testCompletePurchaseSuccess()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = $this->gateway->completePurchase($this->completePurchaseOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('5eShkHH4BI6asZUa', $response->getTransactionReference());
    }

    public function testCompletePurchaseFailure()
    {
        $this->setMockHttpResponse('CompletePurchaseFailure.txt');
        $response = $this->gateway->completePurchase($this->completePurchaseOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
    }
}
