<?php

namespace Omnipay\AllPay\Message;

class CompletePurchaseResponse extends Response
{
    public function isSuccessful()
    {
        if (isset($this->data['RespCode']) && $this->data['RespCode'] == '00') {
            return true;
        }

        return false;
    }

    public function getTransactionReference()
    {
        if (isset($this->data['transID'])) {
            return $this->data['transID'];
        }

        return null;
    }

    public function getCode()
    {
        return $this->data['RespCode'];
    }

    public function getMessage()
    {
        if (isset($this->data['RespMsg'])) {
            return $this->data['RespMsg'];
        }

        return null;
    }
}
