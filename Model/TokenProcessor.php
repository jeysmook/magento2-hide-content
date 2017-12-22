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
use Magento\Framework\App\ResponseInterface;

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
     * Hide required content
     *
     * @param ResponseInterface $response
     */
    public function execute(ResponseInterface $response)
    {
        $contentType = $response->getHeader('Content-Type');
        $body = $response->getBody();

        if (empty($contentType) && !empty($body)) {
            $tokens = $this->tokenManager->getTokens();
            foreach ($tokens as $token) {
                if ($token->getIsApply()) {
                    $body = $this->hideContent($body, $token);
                }
            }

            $response->setBody($body);
        }
    }

    /**
     * Hide token content
     *
     * @param string $body
     * @param TokenInterface $token
     * @return string
     */
    private function hideContent(string $body, TokenInterface $token)
    {
        $open = $this->tokenManager->getHtmlOpen($token->getName());
        $close = $this->tokenManager->getHtmlClose($token->getName());
        $closeLength = mb_strlen($close);

        $oi = $ci = 0;
        do {
            $oi = mb_strrpos($body, $open);
            $ci = mb_strpos($body, $close, $oi);

            if (false === $oi || false === $ci)
                break;

            $search = mb_substr($body, $oi, $ci - $oi + $closeLength);
            $body = str_replace($search, '', $body);

        } while(false !== $oi && false !== $ci);

        return $body;
    }
}