<?php
/**
 * Subscription plugin for Craft CMS 3.x
 *
 * Subscription
 *
 * @link      craft.test
 * @copyright Copyright (c) 2020 Timon
 */

namespace aenmsubscription\subscription\records;

use aenmsubscription\subscription\Subscription;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    Timon
 * @package   Subscription
 * @since     1.0.0
 */
class SubscriptionRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription_subscriptionrecord}}';
    }
}
