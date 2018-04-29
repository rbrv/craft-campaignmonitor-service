<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-synch
 * @copyright Copyright (c) Clearbold, LLC
 *
 * ...
 *
 */

namespace clearbold\cmservice\models;

use clearbold\cmservice\CmService;

use Craft;
use craft\base\Model;

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
    public function rules()
    {
        return [
            [['apiKey'], 'string'],
            [['apiKey'], 'required'],
            [['clientId'], 'string'],
            [['clientId'], 'required'],
        ];
    }
}