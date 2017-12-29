<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Model\Token;

use Magento\Framework\Encryption\EncryptorInterface;

class HideContent extends AbstractToken
{
    /**
     * Token name const
     */
    const TOKEN_NAME = 'hide_content';

    public function __construct(
        EncryptorInterface $encryptor,
        string $name = self::TOKEN_NAME
    ) {
        parent::__construct($encryptor, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsApply()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return __('Hide content token');
    }
}