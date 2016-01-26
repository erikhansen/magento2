<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Developer\Model\Config\Source;

use Magento\Framework\App\State;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class TemplateHintsDisplayStyle
 */
class TemplateHintsDisplayStyle implements ArrayInterface
{
    /**
     * Tooltip option
     */
    const DISPLAY_STYLE_TOOLTIP = 'tooltip';

    /**
     * Format for PhpStorm
     */
    const DISPLAY_STYLE_HTML_COMMENT = 'html_comment';

    /**
     * Return list of display styles
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::DISPLAY_STYLE_TOOLTIP, 'label' => __('Tooltip')],
            ['value' => self::DISPLAY_STYLE_HTML_COMMENT, 'label' => __('HTML Comment')],
        ];
    }
}
