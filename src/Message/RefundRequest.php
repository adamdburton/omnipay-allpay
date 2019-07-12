<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{
    protected $apiEndpoint = 'refund';

    /**
     * @return array|mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'transactionReference',
            'originalOrderNumber',
            'amount',
            'paymentMethod',
            'currency'
        );

        $data = $this->getBaseData();
        $data['transType'] = 'REFD';
        $data['orderNum'] = $this->getTransactionReference();
        $data['origOrderNum'] = $this->getOriginalOrderNumber();
        $data['returnAmount'] = $this->getAmount();
        $data['paymentSchema'] = $this->getPaymentMethod();
        $data['orderCurrency'] = $this->getCurrency();

        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new RefundResponse($this, $data);
    }

    public function setOriginalOrderNumber($value)
    {
        return $this->setParameter('originalOrderNumber', $value);
    }

    public function getOriginalOrderNumber()
    {
        return $this->getParameter('originalOrderNumber');
    }
}
