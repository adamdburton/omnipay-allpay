<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Message\RequestInterface;

class CompletePurchaseResponse extends Response
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = json_decode($data, true);
    }

    public function isSuccessful()
    {
        return isset($this->data['RespCode']) && $this->data['RespCode'] == '00';
    }

    public function getTransactionReference()
    {
        if (isset($this->data['transID'])) {
            return $this->data['transID'];
        }
    }

    public function getCode()
    {
        if (isset($this->data['RespCode'])) {
            return $this->data['RespCode'];
        }
    }

    public function getMessage()
    {
        if (isset($this->data['RespMsg'])) {
            return $this->data['RespMsg'];
        }
    }
}
