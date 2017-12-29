<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Test\Block\Widget;

use Jeysmook\HideContent\Block\Widget\Token;
use Jeysmook\HideContent\Model\Token\HideContent;
use Jeysmook\HideContent\Model\TokenManager;
use Magento\Framework\Encryption\Encryptor;

class TokenTest extends \PHPUnit\Framework\TestCase
{
    /** @var HideContent */
    protected $token;

    /** @var TokenManager */
    protected $tokenManager;

    /** @var Token */
    protected $linkElement;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $encryptor = $objectManager->getObject(Encryptor::class);
        $this->token = $objectManager->getObject(HideContent::class, ['encryptor' => $encryptor]);
        $this->tokenManager = $objectManager->getObject(TokenManager::class, [
            'tokens' => [HideContent::TOKEN_NAME => $this->token]
        ]);
        $this->linkElement = $objectManager->getObject(Token::class, [
            'tokenManager' => $this->tokenManager
        ]);
    }

    public function testGetTokenModeEmpty()
    {
        $this->assertEmpty($this->linkElement->getTokenMode());
    }

    public function testGetTokenMode()
    {
        $tokenMode = Token::MODE_OPEN;
        $this->linkElement->setData('token_mode',  $tokenMode);
        $this->assertEquals($tokenMode, $this->linkElement->getTokenMode());
    }

    public function testGetTokenNameEmpty()
    {
        $this->assertEmpty($this->linkElement->getTokenName());
    }

    public function testGetTokenName()
    {
        $tokenName = $this->token->getName();
        $this->linkElement->setData('token_name',  $tokenName);
        $this->assertEquals($tokenName, $this->linkElement->getTokenName());
    }

    public function testToHtmlEmpty()
    {
        $this->assertEmpty($this->linkElement->toHtml());
    }

    public function testToHtmlModeOpen()
    {
        $tokenMode = Token::MODE_OPEN;
        $tokenName = $this->token->getName();
        $this->linkElement->setData('token_mode',  $tokenMode);
        $this->linkElement->setData('token_name',  $tokenName);
        $this->assertEquals($this->linkElement->toHtml(), $this->tokenManager->getHtmlOpen($tokenName));
    }

    public function testToHtmlModeClose()
    {
        $tokenMode = Token::MODE_CLOSE;
        $tokenName = $this->token->getName();
        $this->linkElement->setData('token_mode',  $tokenMode);
        $this->linkElement->setData('token_name',  $tokenName);
        $this->assertEquals($this->linkElement->toHtml(), $this->tokenManager->getHtmlClose($tokenName));
    }
}
