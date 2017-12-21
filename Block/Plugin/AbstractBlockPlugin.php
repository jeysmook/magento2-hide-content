<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Block\Plugin;

use Jeysmook\HideContent\Api\TokenManagerInterface;
use Magento\Framework\View\Element\AbstractBlock;

class AbstractBlockPlugin
{
    /** @var TokenManagerInterface */
    private $tokenManager;

    public function __construct(
        TokenManagerInterface $tokenManager
    ) {
        $this->tokenManager = $tokenManager;
    }

    /**
     * Call plugin
     *
     * @param AbstractBlock $subject
     * @param $result
     * @param $method
     * @param $args
     * @return string
     */
    public function after__call(AbstractBlock $subject, $result, $method, $args)
    {
        if (isset($args[0]) && is_string($args[0])) {
            switch ($method) {
                case 'getHtmlOpenToken':
                    return $this->tokenManager->getHtmlOpen($args[0]);
                case 'getHtmlCloseToken':
                    return $this->tokenManager->getHtmlClose($args[0]);
            }
        }

        return $result;
    }
}
