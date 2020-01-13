<?php
/**
 * Subscription plugin for Craft CMS 3.x
 *
 * Subscription
 *
 * @link      craft.test
 * @copyright Copyright (c) 2020 Timon
 */

namespace aenmsubscription\subscription\controllers;

use aenmsubscription\subscription\Subscription;
use aenmsubscription\subscription\records\SubscriptionRecord;

use Craft;
use craft\elements\Entry;
use craft\web\Controller;
use craft\errors\ElementNotFoundException;

/**
 * @author    Timon
 * @package   Subscription
 * @since     1.0.0
 */
class SubscribeController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['store', 'destroy'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionStore()
    {
        $this->requireLogin();
        $this->requirePostRequest();

        $communityId = Craft::$app->getRequest()->getRequiredBodyParam('community_id');
        $community = Entry::find()
            ->section('community')
            ->id($communityId)
            ->one();

        if (! $community) {
            throw new ElementNotFoundException("Community [{$communityId}] does not exists.");
        }

        $subscription = new SubscriptionRecord;
        $subscription->author_id = Craft::$app->getUser()->id;
        $subscription->community_id = $communityId;

        $subscription = Subscription::getInstance()->subscription->save($subscription);

        return $this->asJson(['message' => 'Subscribed']);
    }

    public function actionDestroy()
    {
        $this->requireLogin();
        $this->requirePostRequest();

        $communityId = Craft::$app->getRequest()->getRequiredBodyParam('community_id');

        $subscription = SubscriptionRecord::find()
            ->where(['author_id' => Craft::$app->getUser()->id, 'community_id' => $communityId])
            ->one();

        if ($subscription) {
            Subscription::getInstance()->subscription->delete($subscription);
        }

        return $this->asJson(['message' => 'Unsubscribed']);
    }
}
