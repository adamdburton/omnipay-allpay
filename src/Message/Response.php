<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = json_decode($data, true);
    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    public function isSuccessful()
    {
        return isset($this->data['success']);
    }
}
