<?php
/**
 * Copyright © Spyrosoft. All rights reserved.
 */

namespace Spyrosoft\MCPChatBot\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class InstallData
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * InstallData constructor.
     *
     * @param WriterInterface $configWriter
     */
    public function __construct(WriterInterface $configWriter)
    {
        $this->configWriter = $configWriter;
    }

    /**
     * Install module data
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Set default configuration values
        $this->configWriter->save(
            'spyrosoft_mcpchatbot/general/enabled',
            1,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );

        $this->configWriter->save(
            'spyrosoft_mcpchatbot/general/require_token',
            0,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );

        $this->configWriter->save(
            'spyrosoft_mcpchatbot/general/return_policy',
            'You may return items within 30 days of delivery. Please contact support for RMA instructions.',
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );

        $setup->endSetup();
    }
}
