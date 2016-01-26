<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Developer\Model\Config\Source;

use Magento\Framework\App\State;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class TemplateHintsFileLinkFormat
 */
class TemplateHintsFileLinkFormat implements ArrayInterface
{
    /**
     * Disabled option
     */
    const FORMAT_DISABLE = 'disable';

    /**
     * Format for PhpStorm
     */
    const FORMAT_PHPSTORM = 'phpstorm';

    /**
     * Format for TextMate
     */
    const FORMAT_TEXTMATE = 'textmate';

    /**
     * Format for custom file link
     */
    const FORMAT_CUSTOM = 'custom';

    /**
     * Return list of template hints file link formats
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::FORMAT_DISABLE, 'label' => __('Disable')],
            ['value' => self::FORMAT_PHPSTORM, 'label' => __('PhpStorm')],
            ['value' => self::FORMAT_TEXTMATE, 'label' => __('TextMate')],
            ['value' => self::FORMAT_CUSTOM, 'label' => __('Custom')]
        ];
    }
}
