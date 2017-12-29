<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Block\Widget\Token;

use Jeysmook\HideContent\Block\Widget\Token;

class Open extends Token
{
    /**
     * {@inheritdoc}
     */
    public function getTokenMode()
    {
        return Token::MODE_OPEN;
    }
}
