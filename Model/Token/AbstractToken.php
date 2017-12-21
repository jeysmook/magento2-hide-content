<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Model\Token;

use Jeysmook\HideContent\Api\Data\TokenInterface;
use Magento\Framework\Encryption\EncryptorInterface;

abstract class AbstractToken implements TokenInterface
{
    /** @var EncryptorInterface */
    private $encryptor;

    /** @var string */
    private $name;

    /** @var string */
    private $hash;

    public function __construct(
        EncryptorInterface $encryptor,
        string $name = ''
    ) {
        $this->encryptor = $encryptor;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsApply()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getHash()
    {
        if (!$this->hash) {
            $this->hash = $this->encryptor->getHash($this->getName());
        }

        return $this->hash;
    }
}