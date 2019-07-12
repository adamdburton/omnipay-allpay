<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    protected $apiEndpoint = 'orderquery';

    /**
     * @return array|mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionReference', 'paymentMethod');

        $data = $this->getBaseData();
        $data['transType'] = 'INQY';
        $data['orderNum'] = $this->getTransactionReference();
        $data['paymentSchema'] = $this->getPaymentMethod();

        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
