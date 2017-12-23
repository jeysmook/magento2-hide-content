<?php
/**
 * This extension will help hide content
 *
 * Copyright © Dmitry Kaplin - All rights reserved.
 * See LICENSE.txt bundled with this module for license details.
 */
namespace Jeysmook\HideContent\Api\Data;

interface TokenInterface
{
    /**
     * Check is apply token and retrieve result
     *
     * @return boolean
     */
    public function getIsApply();

    /**
     * Retrieve token name
     *
     * @return string
     */
    public function getName();

    /**
     * Retrieve token label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Retrieve token hash
     *
     * @return string
     */
    public function getHash();
}