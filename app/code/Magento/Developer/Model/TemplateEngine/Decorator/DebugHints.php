<?php
/**
 * Decorator that inserts debugging hints into the rendered block contents
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Magento\Developer\Model\TemplateEngine\Decorator;

use \Magento\Framework\View\TemplateEngineInterface;
use \Magento\Framework\View\Element\BlockInterface;

/**
 * Class DebugHints
 */
class DebugHints implements TemplateEngineInterface
{
    /**
     * @var TemplateEngineInterface
     */
    protected $subject;

    /**
     * @var string
     */
    protected $fileLinkFormat;

    /**
     * @var string
     */
    protected $fileLinkFormatCustom;

    /**
     * @var string
     */
    protected $displayStyle;

    /**
     * @param TemplateEngineInterface $subject
     * @param string $fileLinkFormat
     * @param string $fileLinkFormatCustom
     * @param string $displayStyle
     */
    public function __construct(TemplateEngineInterface $subject, $fileLinkFormat, $fileLinkFormatCustom, $displayStyle)
    {
        $this->subject = $subject;
        $this->fileLinkFormat = $fileLinkFormat;
        $this->fileLinkFormatCustom = $fileLinkFormatCustom;
        $this->displayStyle = $displayStyle;
    }

    /**
     * Insert debugging hints into the rendered block contents
     *
     * {@inheritdoc}
     */
    public function render(BlockInterface $block, $templateFile, array $dictionary = [])
    {
        $result = $this->subject->render($block, $templateFile, $dictionary);
        $result = $this->_renderTemplateHints($result, $block, $templateFile);
        return $result;
    }

    /**
     * Insert template debugging hints into the rendered block contents
     *
     * @param string $blockHtml
     * @param BlockInterface $block
     * @param string $templateFile
     * @return string
     */
    protected function _renderTemplateHints($blockHtml, BlockInterface $block, $templateFile)
    {
        // TODO: Review how \Aoe_TemplateHints_Helper_BlockInfo::getBlockInfo is structuring block info
        $blockClass = get_class($block);
        $blockInfo = [
            'Name' => $block->getNameInLayout(),
            'Alias' => $block->getBlockAlias(),
            'Template' => $templateFile,
            'Block Class' => $blockClass,
            'Module' => $block->getModuleName()
        ];
        return <<<HTML
<div class="debugging-hints" style="position: relative; border: 1px dotted red; margin: 6px 2px; padding: 18px 2px 2px 2px;">
<div class="debugging-hint-template-file" style="position: absolute; top: 0; padding: 2px 5px; font: normal 11px Arial; background: red; left: 0; color: white; white-space: nowrap;" onmouseover="this.style.zIndex = 999;" onmouseout="this.style.zIndex = 'auto';" title="{$templateFile}">{$templateFile}</div>
{$blockHtml}
</div>
HTML;
    }
}
