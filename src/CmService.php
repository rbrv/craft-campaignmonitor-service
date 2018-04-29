<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-service
 * @copyright Copyright (c) Clearbold, LLC
 */

namespace clearbold\cmservice;

use clearbold\cmservices\services\CampaignMonitorService;
use clearbold\cmservices\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use yii\base\Event;

/**
 * Campaign Monitor Service is an API wrapper and settings manager for Campaign Monitor plugins for Craft.
 *
 * @author Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since 0.1.0
 */
class CmServices extends Plugin
{
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
