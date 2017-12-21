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
        $openToken = $this->tokenManager->getHtmlOpen($token->getName());
        $closeToken = $this->tokenManager->getHtmlClose($token->getName());
        $closeTokenLength = mb_strlen($closeToken);

        $openIndex = $closeIndex = 0;
        $modifyBody = $body;

        do {
            $openIndex = mb_strpos($modifyBody, $openToken);
            $closeIndex = mb_strpos($modifyBody, $closeToken);

            if (false === $openIndex || false === $closeIndex)
                break;

            $modifyBody = substr_replace(
                $modifyBody,
                '',
                $openIndex,
                $closeIndex - $openIndex + $closeTokenLength
            );
        } while(false !== $openIndex && false !== $closeIndex);

        if (!empty($modifyBody))
            return $modifyBody;

        return $body;
    }
}