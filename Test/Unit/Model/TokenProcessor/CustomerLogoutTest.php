<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Test\Model\TokenProcessor;

use Jeysmook\HideContent\Api\Data\TokenInterface;
use Jeysmook\HideContent\Model\Token\CustomerLogout;
use Jeysmook\HideContent\Model\TokenManager;
use Jeysmook\HideContent\Model\TokenProcessor;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class CustomerLogoutTest extends \PHPUnit\Framework\TestCase
{
    /** @var ObjectManager */
    protected $objectManager;
    /** @var TokenProcessor */
    protected $tokenProcessor;
    /** @var TokenManager */
    protected $tokenManager;
    /** @var TokenInterface */
    protected $token;
    /** @var array */
    protected $contents;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $encryptor = $this->objectManager->getObject(\Magento\Framework\Encryption\Encryptor::class);
        $this->token = $this->objectManager->getObject(CustomerLogout::class, ['encryptor' => $encryptor]);
        $this->tokenManager = $this->objectManager->getObject(TokenManager::class, [
            'tokens' => [$this->token->getName() => $this->token]
        ]);
        $this->tokenProcessor = $this->objectManager->getObject(TokenProcessor::class, [
            'tokenManager' => $this->tokenManager
        ]);
        $this->setUpContents();
    }

    protected function setUpContents()
    {
        $openToken = $this->tokenManager->getHtmlOpen($this->token->getName());
        $closeToken = $this->tokenManager->getHtmlClose($this->token->getName());

        $this->contents = [];

        //add all examples
        for ($i = 1; $i <= 2; $i++) {
            $example = file_get_contents(__DIR__ . '/../../_files/token-processor/example' . $i . '.html');
            $result = file_get_contents(__DIR__ . '/../../_files/token-processor/result' . $i . '.html');
            $example = str_replace([
                '<!--open-->',
                '<!--close-->'
            ], [$openToken, $closeToken], $example);

            $this->contents[] = [$example, $result];
        }
    }

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
