<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Model;

use Jeysmook\HideContent\Api\Data\TokenInterface;
use Jeysmook\HideContent\Api\TokenManagerInterface;

class TokenManager implements TokenManagerInterface
{
    /** @var array */
    private $tokens;

    public function __construct(
        array $tokens = []
    ) {
        $this->tokens = $tokens;
    }

    /**
     * {@in
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlOpen(string $key)
    {
        $tokenInstance = isset($this->tokens[$key]) ? $this->tokens[$key] : null;

        if ($tokenInstance instanceof TokenInterface) {
            return '<!--start:' . $tokenInstance->getHash() . '-->';
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlClose(string $key)
    {
        $tokenInstance = isset($this->tokens[$key]) ? $this->tokens[$key] : null;

        if ($tokenInstance instanceof TokenInterface) {
            return '<!--end:' . $tokenInstance->getHash() . '-->';
        }

        return '';
    }
}