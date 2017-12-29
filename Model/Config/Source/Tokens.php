<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Model\Config\Source;

use Jeysmook\HideContent\Api\TokenManagerInterface;
use Magento\Framework\Option\ArrayInterface;

class Tokens implements ArrayInterface
{
    /** @var TokenManagerInterface */
    private $tokenManager;

    public function __construct(
        TokenManagerInterface $tokenManager
    ) {
        $this->tokenManager = $tokenManager;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->tokenManager->getTokens() as $token) {
            $options[] = [
                'value' => $token->getName(),
                'label' => $token->getLabel()
            ];
        }
        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $options = [];
        foreach ($this->toOptionArray() as $option) {
            $options[$options['value']] = $option['label'];
        }
        return $options;
    }
}
