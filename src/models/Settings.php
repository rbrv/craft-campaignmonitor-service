<?php
/**
 * @link https://github.com/clearbold/craft-campaignmonitor-synch
 * @copyright Copyright (c) Clearbold, LLC
 *
 * ...
 *
 */

namespace clearbold\cmservice\models;

use clearbold\cmservice\CmService;

use Craft;
use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;

/**
 * @author    Mark Reeves, Clearbold, LLC <hello@clearbold.com>
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $apiKey = null;
    /**
     * @var string
     */
    public $clientId = null;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'parser' => [
                'class' => EnvAttributeParserBehavior::class,
                'attributes' => [
                    'apiKey',
                    'clientId',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['apiKey'], 'string'],
            [['apiKey'], 'required'],
            [['clientId'], 'string'],
            [['clientId'], 'required'],
        ];
    }

    /**
     * Retrieve parsed API Key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return Craft::parseEnv($this->apiKey);
    }

    /**
     * Retrieve parse Client Id
     *
     * @return string
     */
    public function getClientId(): string
    {
        return Craft::parseEnv($this->clientId);
    }
}