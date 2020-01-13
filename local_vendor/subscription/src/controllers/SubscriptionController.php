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
use aenmsubscription\subscription\Subscription as Plugin;

/**
 * @author    Timon
 * @package   Subscription
 * @since     1.0.0
 */
class SubscriptionController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'new-message'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->requireLogin();

        $subscriptions = (new \craft\db\Query())
            ->select(['community_id'])
            ->from(['{{%subscription_subscriptionrecord}}'])
            ->where(['author_id' => Craft::$app->getUser()->id])
            ->all();

        if ($subscriptions) {
            $subscriptions = array_map(function ($subscription) {
                return $subscription['community_id'];
            }, $subscriptions);
        }

        return $this->asJson($subscriptions);
    }

    public function actionNewMessage()
    {
        // $this->requireLogin();
        $this->requirePostRequest();

        $communityId = Craft::$app->getRequest()->getRequiredBodyParam('community_id');

        $subscriptions = (new \craft\db\Query())
            ->select(['author_id'])
            ->from(['{{%subscription_subscriptionrecord}}'])
            ->where(['community_id' => $communityId])
            ->all();

        foreach ($subscriptions as $subscription) {
            $user = \craft\elements\User::find()
                ->id($subscription->author_id)
                ->one();

            return Craft::$app
                ->getMailer()
                ->compose()
                ->setTo($user->email)
                ->setSubject('New community message')
                ->setHtmlBody("New message created within community {$communityId}")
                ->send();
        }
    }
}
