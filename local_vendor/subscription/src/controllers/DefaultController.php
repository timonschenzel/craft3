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

use Craft;
use craft\web\Controller;

/**
 * @author    Timon
 * @package   Subscription
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the DefaultController actionIndex() method';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the DefaultController actionDoSomething() method';

        return $result;
    }
}
