<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Test\Model;

use Jeysmook\HideContent\Model\Token\CustomerLogout;
use Jeysmook\HideContent\Model\TokenProcessor;

class TokenProcessorTest extends \PHPUnit\Framework\TestCase
{
    /** @var TokenProcessor */
    private $tokenProcessor;

    /** @var CustomerLogout */
    private $token;

    /**
     * Setup test data
     */
    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->tokenProcessor = $objectManager->getObject(TokenProcessor::class);
        $this->token = $objectManager->getObject(CustomerLogout::class);
    }

    /**
     * Test token processor
     */
    public function testTokenProcessor()
    {
        $this->assertEquals(
            '',
            ''
        );
    }
}
