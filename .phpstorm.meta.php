<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'AllPay' instanceof \Omnipay\AllPay\AllPayGateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'AllPay' instanceof \Omnipay\AllPay\AllPayGateway,
      ],
    ];
}
