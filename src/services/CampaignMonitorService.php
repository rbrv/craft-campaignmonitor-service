<?php
/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-lsynchists
 * @copyright Copyright (c) Clearbold, LLC
 *
 * Synch your Craft members or "people" entries with your Campaign Monitor subscriber lists.
 *
 */

namespace clearbold\cmservice\services;

require_once CRAFT_VENDOR_PATH.'/campaignmonitor/createsend-php/csrest_clients.php';
require_once CRAFT_VENDOR_PATH.'/campaignmonitor/createsend-php/csrest_lists.php';
require_once CRAFT_VENDOR_PATH.'/campaignmonitor/createsend-php/csrest_subscribers.php';
require_once CRAFT_VENDOR_PATH.'/campaignmonitor/createsend-php/csrest_campaigns.php';

use clearbold\cmservice\CmService;

use Craft;
use craft\base\Component;

/**
 * @author    Mark Reeves
 * @since     0.1.0
 */
class CampaignMonitorService extends Component
{
    /**
     * @var settings
     * @todo declare it once
     */

    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function getLists()
    {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Clients(
                $settings->clientId,
                $auth);

            $result = $client->get_lists();

            if($result->was_successful()) {
                $body = array();
                foreach ($result->response as $list) {
                    $body[] = $list;
                }
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    public function getListStats($listId = '')
    {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Lists(
                $listId,
                $auth);

            $result = $client->get_stats();

            if($result->was_successful()) {
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $result->response
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    public function getList($listId = '')
    {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Lists(
                $listId,
                $auth);

            $result = $client->get();

            if($result->was_successful()) {
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $result->response
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    public function getActiveSubscribers($listId = '', $params = []) {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Lists(
                $listId,
                $auth);

            $result = $client->get_active_subscribers('', 1, 10, 'date', 'desc');

            if($result->was_successful()) {
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $result->response->Results
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    /*
     * @return mixed
     */
    public function importSubscribers($listId = '', $subscribers = array())
    {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Subscribers(
                $listId,
                $auth);
            $result = $client->import($subscribers, false);

            if($result->was_successful()) {
                $body = $result->response;
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    /*
     * @return mixed
     */
    public function updateSubscriber($listId = '', $oldEmail = '', $email = '', $subscriber = array()) {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Subscribers(
                $listId,
                $auth);
            $result = $client->update($oldEmail, $subscriber);

            if($result->was_successful()) {
                $body = $result->response;
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    /*
     * @return mixed
     */
    public function addSubscriber($listId = '', $subscriber = array())
    {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Subscribers(
                $listId,
                $auth);
            $result = $client->add($subscriber);

            if($result->was_successful()) {
                $body = $result->response;
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    public function unsubSubscriber($listId = '', $email = '')
    {
        $settings = CmService::$plugin->getSettings();

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Subscribers(
                $listId,
                $auth);
            $result = $client->unsubscribe($email);

            if($result->was_successful()) {
                $body = $result->response;
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }

    /*
     * @return mixed
     */
    // public function createCampaign($campaign = array())
    public function createCampaign()
    {
        $settings = CmService::$plugin->getSettings();

        $campaign = array(
            'Subject' => 'Campaign Subject',
            'Name' => 'Campaign Name',
            'FromName' => 'Campaign From Name',
            'FromEmail' => 'hello@clearbold.com',
            'ReplyTo' => 'hello@clearbold.com',
            'HtmlUrl' => 'http://email.clearbold.com/wide-template/email/live.html',
            # 'TextUrl' => 'Optional campaign text import URL',
            'ListIDs' => array('8f9c4e3094ab4d389d09db06215fdee9'),
            // 'SegmentIDs' => array('First Segment', 'Second Segment')
        );

        try {
            $auth = array(
                'api_key' => (string)$settings->apiKey);
            $client = new \CS_REST_Campaigns(
                NULL,
                $auth);
            $result = $client->create('2b87d08d39d83bc24d44ba44a1f06020', $campaign);

            if($result->was_successful()) {
                $body = $result->response;
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }
}