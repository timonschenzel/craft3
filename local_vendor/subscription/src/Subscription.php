<?php
/**
 * Subscription plugin for Craft CMS 3.x
 *
 * Subscription
 *
 * @link      craft.test
 * @copyright Copyright (c) 2020 Timon
 */

namespace aenmsubscription\subscription;

use aenmsubscription\subscription\services\SubscriptionService as SubscriptionServiceService;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Subscription
 *
 * @author    Timon
 * @package   Subscription
 * @since     1.0.0
 *
 * @property  SubscriptionServiceService $subscriptionService
 */
class Subscription extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Subscription
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'subscription/default';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'subscription/default/do-something';
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'subscription',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

        $this->setComponents([
            'subscription' => SubscriptionServiceService::class,
        ]);
    }

    // Protected Methods
    // =========================================================================

}
