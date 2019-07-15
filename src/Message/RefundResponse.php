<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Message\RequestInterface;

class RefundResponse extends Response
{
    public function getTransactionReference()
    {
        if (isset($this->data['transID'])) {
            return $this->data['transID'];
        }
    }

    public function isSuccessful()
    {
        return isset($this->data['RespCode']) && $this->data['RespCode'] == '00';
    }

    public function getMessage()
    {
        return $this->data['RespMsg'];
    }
}
