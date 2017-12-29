<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Block\Widget;

use Jeysmook\HideContent\Api\TokenManagerInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;
use Magento\Widget\Block\BlockInterface;

class Token extends AbstractBlock implements BlockInterface
{
    /**
     * Mode consts
     */
    const MODE_OPEN = 'open';
    const MODE_CLOSE = 'close';

    /** @var TokenManagerInterface */
    private $tokenManager;

    public function __construct(
        Context $context,
        TokenManagerInterface $tokenManager,
        array $data = []
    ) {
        $this->tokenManager = $tokenManager;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve token name
     *
     * @return string
     */
    public function getTokenName()
    {
        return (string)$this->getData('token_name');
    }

    /**
     * Retrieve token mode
     *
     * @return string
     */
    public function getTokenMode()
    {
        return (string)$this->getData('token_mode');
    }

    /**
     * Render html token
     *
     * @return string
     */
    public function toHtml()
    {
        $tokenName = $this->getTokenName();
        $tokenMode = $this->getTokenMode();
        if (!empty($tokenName) && !empty($tokenMode)) {
            switch ($tokenMode) {
                case self::MODE_OPEN:
                    return $this->tokenManager->getHtmlOpen($tokenName);
                case self::MODE_CLOSE:
                    return $this->tokenManager->getHtmlClose($tokenName);
            }
        }

        return '';
    }
}
