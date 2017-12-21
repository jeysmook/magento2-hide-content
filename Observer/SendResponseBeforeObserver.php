<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Observer;

use Jeysmook\HideContent\Model\TokenProcessor;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SendResponseBeforeObserver implements ObserverInterface
{
    /** @var TokenProcessor */
    private $tokenProcessor;

    public function __construct(
        TokenProcessor $tokenProcessor
    ) {
        $this->tokenProcessor = $tokenProcessor;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();

        if ($response instanceof ResponseInterface)
            $this->tokenProcessor->execute($response);
    }
}
