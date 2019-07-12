<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    protected $apiEndpoint = 'unifiedorder';

    /**
     * @return array|mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'transactionReference',
            'amount',
            'paymentMethod',
            'currency',
            'returnUrl',
            'notifyUrl',
            'description',
            'items'
        );

        $data = $this->getBaseData();
        $data['transType'] = 'PURC';
        $data['orderNum'] = $this->getTransactionReference();
        $data['orderAmount'] = $this->getAmount();
        $data['paymentSchema'] = $this->getPaymentMethod();
        $data['orderCurrency'] = $this->getCurrency();
        $data['frontURL'] = $this->getReturnUrl();
        $data['backURL'] = $this->getNotifyUrl();
        $data['goodsInfo'] = $this->getDescription();
        $data['detailInfo'] = base64_encode(json_encode($this->getItems()));

        // Payment specific stuff

        switch ($data['paymentSchema']) {
            case 'WX':
                $data['tradeFrom'] = 'QUICK';
                break;
            case 'AP':
                $data['tradeFrom'] = 'WEB';
                break;
            case 'UP':
                $data['tradeFrom'] = 'H5';
                break;
        }

        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
