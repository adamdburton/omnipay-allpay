<?php

namespace Omnipay\AllPay;

use Omnipay\AllPay\Message\AuthorizeRequest;
use Omnipay\AllPay\Message\CompletePurchaseRequest;
use Omnipay\AllPay\Message\PurchaseRequest;
use Omnipay\AllPay\Message\RefundRequest;
use Omnipay\Common\AbstractGateway;

/**
 * AllPay Gateway
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'AllPay (allpayx.com)';
    }

    public function getDefaultParameters()
    {
        return [
            'testMode' => false,
            'merchantId' => '',
            'signature' => '',
            'transTime' => date('YmdHis')
        ];
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    public function setTransTime($value)
    {
        return $this->setParameter('transTime', $value);
    }

    public function getTransTime()
    {
        return $this->getParameter('transTime');
    }

    public function purchase(array $options = array())
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function completePurchase(array $options = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    public function refund(array $options = array())
    {
        return $this->createRequest(RefundRequest::class, $options);
    }
}
