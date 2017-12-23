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

class CustomerLogout extends AbstractToken
{
    /**
     * Token name const
     */
    const TOKEN_NAME = 'customer_logout';

    /** @var Context */
    protected $httpContext;

    /** @var Session */
    protected $customerSession;

    public function __construct(
        EncryptorInterface $encryptor,
        Context $httpContext,
        Session $customerSession,
        string $name = self::TOKEN_NAME
    ) {
        $this->httpContext = $httpContext;
        $this->customerSession = $customerSession;
        parent::__construct($encryptor, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsApply()
    {
        return true !== $this->isLoggedIn();
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return __('Customer logout token');
    }

    /**
     * Check is customer logged in
     *
     * @return boolean
     */
    protected function isLoggedIn()
    {
        $loggedIn = $this->httpContext
            ->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        if (null === $loggedIn) {
            $loggedIn = $this->customerSession->isLoggedIn();
        }

        return (boolean)$loggedIn;
    }
}