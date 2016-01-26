<?php
/**
 * Plugin for the template engine factory that passes in configured settings
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Developer\Model\TemplateEngine\Plugin;

use Magento\Developer\Helper\Data as DevHelper;
use Magento\Developer\Model\TemplateEngine\Decorator\DebugHintsFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\TemplateEngineFactory;
use Magento\Framework\View\TemplateEngineInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class DebugHints
{
    /**
     * XPath of configuration of the file link format
     */
    const XML_PATH_DEBUG_TEMPLATE_HINTS_FILE_LINK_FORMAT = 'dev/debug/template_hints_file_link_format';

    /**
     * XPath of configuration of the custom file link format
     */
    const XML_PATH_DEBUG_TEMPLATE_HINTS_FILE_LINK_FORMAT_CUSTOM = 'dev/debug/template_hints_file_link_format_custom';

    /**
     * XPath of configuration of the display style
     */
    const XML_PATH_DEBUG_TEMPLATE_HINTS_DISPLAY_STYLE = 'dev/debug/template_hints_display_style';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var DevHelper
     */
    protected $devHelper;

    /**
     * @var DebugHintsFactory
     */
    protected $debugHintsFactory;

    /**
     * XPath of configuration of the debug hints
     *
     * Allowed values:
     *     dev/debug/template_hints_storefront
     *     dev/debug/template_hints_admin
     *
     * @var string
     */
    protected $debugHintsPath;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param DevHelper $devHelper
     * @param DebugHintsFactory $debugHintsFactory
     * @param string $debugHintsPath
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        DevHelper $devHelper,
        DebugHintsFactory $debugHintsFactory,
        $debugHintsPath
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->devHelper = $devHelper;
        $this->debugHintsFactory = $debugHintsFactory;
        $this->debugHintsPath = $debugHintsPath;
    }

    /**
     * Wrap template engine instance with the debugging hints decorator, depending of the store configuration
     *
     * @param TemplateEngineFactory $subject
     * @param TemplateEngineInterface $invocationResult
     *
     * @return TemplateEngineInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterCreate(
        TemplateEngineFactory $subject,
        TemplateEngineInterface $invocationResult
    ) {
        $storeCode = $this->storeManager->getStore()->getCode();
        if ($this->scopeConfig->getValue($this->debugHintsPath, ScopeInterface::SCOPE_STORE, $storeCode)
            && $this->devHelper->isDevAllowed()) {
            $fileLinkFormat = $this->scopeConfig->getValue(
                self::XML_PATH_DEBUG_TEMPLATE_HINTS_FILE_LINK_FORMAT,
                ScopeInterface::SCOPE_STORE,
                $storeCode
            );
            $fileLinkFormatCustom = $this->scopeConfig->getValue(
                self::XML_PATH_DEBUG_TEMPLATE_HINTS_FILE_LINK_FORMAT_CUSTOM,
                ScopeInterface::SCOPE_STORE,
                $storeCode
            );
            $displayStyle = $this->scopeConfig->getValue(
                self::XML_PATH_DEBUG_TEMPLATE_HINTS_DISPLAY_STYLE,
                ScopeInterface::SCOPE_STORE,
                $storeCode
            );
            return $this->debugHintsFactory->create([
                'subject' => $invocationResult,
                'fileLinkFormat' => $fileLinkFormat,
                'fileLinkFormatCustom' => $fileLinkFormatCustom,
                'displayStyle' => $displayStyle,
            ]);
        }
        return $invocationResult;
    }
}
