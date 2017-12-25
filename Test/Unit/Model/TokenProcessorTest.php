<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Test\Model;

use Jeysmook\HideContent\Model\Token\CustomerLogout;
use Jeysmook\HideContent\Model\TokenManager;
use Jeysmook\HideContent\Model\TokenProcessor;

class TokenProcessorTest extends \PHPUnit\Framework\TestCase
{
    /** @var TokenProcessor */
    private $tokenProcessor;

    /** @var TokenManager */
    private $tokenManager;

    /** @var CustomerLogout */
    private $token;

    /** @var array */
    private $contents;

    /**
     * Setup test data
     */
    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $encryptor = $objectManager->getObject(\Magento\Framework\Encryption\Encryptor::class);
        $this->token = $objectManager->getObject(CustomerLogout::class, [
            'encryptor' => $encryptor
        ]);

        $this->tokenManager = $objectManager->getObject(TokenManager::class, [
            'tokens' => [
                CustomerLogout::TOKEN_NAME => $this->token
            ]
        ]);

        $this->tokenProcessor = $objectManager->getObject(TokenProcessor::class, [
            'tokenManager' => $this->tokenManager
        ]);

        $this->setUpContents();
    }

    /**
     * Setup html content
     */
    private function setUpContents()
    {
        $openToken = $this->tokenManager->getHtmlOpen($this->token->getName());
        $closeToken = $this->tokenManager->getHtmlClose($this->token->getName());

        $this->contents = [];

        //add all examples
        for ($i = 1; $i <= 2; $i++) {
            $example = file_get_contents(__DIR__ . '/../_files/token-processor/example' . $i . '.html');
            $result = file_get_contents(__DIR__ . '/../_files/token-processor/result' . $i . '.html');
            $example = str_replace([
                '<!--open-->',
                '<!--close-->'
            ], [$openToken, $closeToken], $example);

            $this->contents[] = [$example, $result];
        }
    }

    /**
     * Test token processor
     */
    public function testTokenProcessor()
    {
        foreach ($this->contents as $content) {
            $this->assertEquals(
                $this->tokenProcessor->execute($content[0], $this->token),
                $content[1]
            );
        }
    }
}
