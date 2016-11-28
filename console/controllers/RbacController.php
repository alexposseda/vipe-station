<?php

namespace console\controllers;

use console\rbac\CartUpdateRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $createAd = $auth->createPermission('createAd');
        $auth->add($createAd);
        $updateAd = $auth->createPermission('updateAd');
        $auth->add($updateAd);
        $deleteAd = $auth->createPermission('deleteAd');
        $auth->add($deleteAd);

        $changeStatus = $auth->createPermission('changeStatus');
        $auth->add($changeStatus);

        $adminAccess = $auth->createPermission('adminAccess');
        $auth->add($adminAccess);

        $cartAccess = new CartUpdateRule();
        $auth->add($cartAccess);
        $updateOwnAd = $auth->createPermission('updateOwnAd');
        $updateOwnAd->ruleName = $cartAccess->name;
        $auth->add($updateOwnAd);
        $auth->addChild($updateOwnAd, $updateAd);

        $user = $auth->createRole('user');
        $auth->add($user);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $updateAd);
        $auth->addChild($manager, $deleteAd);
        $auth->addChild($manager, $changeStatus);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $adminAccess);
        $auth->addChild($admin, $manager);

        $auth->assign($admin, 1);
    }
}