<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Observer;

use Jeysmook\HideContent\Api\TokenManagerInterface;
use Jeysmook\HideContent\Model\TokenProcessor;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SendResponseBeforeObserver implements ObserverInterface
{
    /** @var TokenProcessor */
    private $tokenProcessor;

    /** @var TokenManagerInterface */
    private $tokenManager;

    public function __construct(
        TokenProcessor $tokenProcessor,
        TokenManagerInterface $tokenManager
    ) {
        $this->tokenProcessor = $tokenProcessor;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();
        if ($response instanceof ResponseInterface) {
            $body = $response->getBody();
            if (!empty($body)) {
                $tokens = $this->tokenManager->getTokens();
                foreach ($tokens as $token) {
                    $body = $this->tokenProcessor->execute($body, $token);
                }

                $response->setBody($body);
            }
        }
    }
}
