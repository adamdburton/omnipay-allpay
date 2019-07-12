<?php

namespace Omnipay\AllPay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends Response implements RedirectResponseInterface
{
    public function isRedirect()
    {
        return !!$this->getFormAction();
    }

    public function isSuccessful()
    {
        return false;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectUrl()
    {
        return $this->getFormAction();
    }

    public function getRedirectData()
    {
        return $this->getFormFields();
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

    protected function getFormAction()
    {
        preg_match("/action=\'(.*?)\'/", $this->data, $matches);

        return $matches[1] ?? null;
    }

    protected function getFormFields()
    {
        preg_match_all("/type=\'hidden\' name=\'(.*?)\' value=\'(.*?)\'/", $this->data, $matches);

        $fields = [];

        foreach ($matches[0] as $i => $match) {
            $fields[$matches[1][$i]] = $matches[2][$i];
        }

        return $fields;
    }
}
