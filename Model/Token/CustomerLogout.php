<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Model\Token;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context;
use Magento\Framework\Encryption\EncryptorInterface;

class CustomerLogout extends CustomerLoggedIn
{
    /**
     * Token name const
     */
    const TOKEN_NAME = 'customer_logout';

    public function __construct(
        EncryptorInterface $encryptor,
        Context $httpContext,
        Session $customerSession,
        string $name = self::TOKEN_NAME
    ) {
        parent::__construct($encryptor, $httpContext, $customerSession, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsApply()
    {
        return true !== $this->isLoggedIn();
    }
}