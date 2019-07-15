<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    const API_VERSION = 'VER000000005';
    const ACQ_ID = '99020344';
    const CHARSET = 'UTF-8';

    protected $liveEndpoint = 'https://api.allpayx.com/api';
    protected $testEndpoint = 'https://testapi.allpayx.com/api';

    protected $apiEndpoint = '';

    public function sendData($data)
    {
        $data['signature'] = $this->sign($data);

        $data = http_build_query($data, '', '&');
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), $headers, $data);
//        dd($httpResponse->getBody()->getContents());
        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    protected function getBaseData()
    {
        $this->validate('merchantId', 'transTime');

        return [
            'version' => static::API_VERSION,
            'charSet' => static::CHARSET,
            'acqID' => static::ACQ_ID,
            'signType' => 'MD5',
            'transTime' => $this->getTransTime(),
            'merID' => $this->getMerchantId()
        ];
    }

    protected function getEndpoint()
    {
        return ($this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint) . '/' . $this->apiEndpoint;
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

    public function setItems($value)
    {
        return $this->setParameter('items', $value);
    }

    public function getItems()
    {
        return $this->getParameter('items');
    }

    public function sign($data)
    {
        ksort($data);

        $str = '';

        foreach ($data as $key => $value) {
            $str .= sprintf('%s=%s', $key, $value) . '&';
        }

        $data = substr($str, 0, -1) . $this->getSignature();

        return md5($data);
    }
}
