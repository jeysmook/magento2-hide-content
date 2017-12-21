<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Api;

use Jeysmook\HideContent\Api\Data\TokenInterface;

interface TokenManagerInterface
{
    /**
     * Retrieve tokens
     *
     * @return TokenInterface[]
     */
    public function getTokens();

    /**
     * Retrieve html open token
     *
     * @param string $key
     * @return string
     */
    public function getHtmlOpen(string $key);

    /**
     * Retrieve html close token
     *
     * @param string $key
     * @return string
     */
    public function getHtmlClose(string $key);
}