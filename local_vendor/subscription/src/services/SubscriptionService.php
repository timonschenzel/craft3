<?php
/**
 * Subscription plugin for Craft CMS 3.x
 *
 * Subscription
 *
 * @link      craft.test
 * @copyright Copyright (c) 2020 Timon
 */

namespace aenmsubscription\subscription\services;

use aenmsubscription\subscription\Subscription;
use aenmsubscription\subscription\records\SubscriptionRecord;

use Craft;
use craft\base\Component;

/**
 * @author    Timon
 * @package   Subscription
 * @since     1.0.0
 */
class SubscriptionService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function save(SubscriptionRecord $subscription)
    {
        $subscription->save();

        return $subscription;
    }

    /*
     * @return mixed
     */
    public function delete(SubscriptionRecord $subscription)
    {
        return $subscription->delete();
    }
}
