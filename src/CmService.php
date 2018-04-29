<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-service
 * @copyright Copyright (c) Clearbold, LLC
 */

namespace clearbold\cmservice;

use clearbold\cmservice\services\CampaignMonitorService;
use clearbold\cmservice\models\Settings;

use Craft;
use craft\base\Plugin;

/**
 * Campaign Monitor Service is an API wrapper and settings manager for Campaign Monitor plugins for Craft.
 *
 * @author Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since 1.0.0
 */
class CmService extends Plugin
{
    public $hasCpSettings = true;
    public static $plugin;

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'campaignmonitor' => \clearbold\cmservice\services\CampaignMonitorService::class,
        ]);

        Craft::info(
            Craft::t(
                'cm-service',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    protected function createSettingsModel()
    {
        return new \clearbold\cmservice\models\Settings();
    }

    protected function settingsHtml()
    {
        return \Craft::$app->getView()->renderTemplate('cm-service/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}
