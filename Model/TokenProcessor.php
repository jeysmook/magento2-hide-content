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

class TokenProcessor
{
    /** @var TokenManagerInterface */
    private $tokenManager;

    public function __construct(
        TokenManagerInterface $tokenManager
    ) {
        $this->tokenManager = $tokenManager;
    }

    /**
     * Hide required content by token
     *
     * @param string $string
     * @param TokenInterface $token
     * @return string
     */
    public function execute(string $string, TokenInterface $token)
    {
        if (!$token->getIsApply()) {
            return $string;
        }

        $open = $this->tokenManager->getHtmlOpen($token->getName());
        $close = $this->tokenManager->getHtmlClose($token->getName());
        $closeLength = mb_strlen($close);

        $oi = $ci = 0;
        do {
            // search last open token
            $oi = mb_strrpos($string, $open);
            // search last close token
            $ci = mb_strpos($string, $close, $oi);

            // if token not found stop loop
            if (false === $oi || false === $ci)
                break;

            // search hidden area and hidden it.
            $search = mb_substr($string, $oi, $ci - $oi + $closeLength);
            $string = str_replace($search, '', $string);

        } while(false !== $oi && false !== $ci);

        return $string;
    }
}