<?php

declare(strict_types=1);

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit(): void
    {
        $auth = Yii::$app->authManager;

        // Remove old permissions
        $auth->removeAll();

        // Create permissions
        $viewBooks = $auth->createPermission('viewBooks');
        $viewBooks->description = 'View books';
        $auth->add($viewBooks);

        $manageBooks = $auth->createPermission('manageBooks');
        $manageBooks->description = 'Manage books (create, update, delete)';
        $auth->add($manageBooks);

        $viewAuthors = $auth->createPermission('viewAuthors');
        $viewAuthors->description = 'View authors';
        $auth->add($viewAuthors);

        $manageAuthors = $auth->createPermission('manageAuthors');
        $manageAuthors->description = 'Manage authors (create, update, delete)';
        $auth->add($manageAuthors);

        $subscribe = $auth->createPermission('subscribe');
        $subscribe->description = 'Subscribe to authors';
        $auth->add($subscribe);

        $viewReports = $auth->createPermission('viewReports');
        $viewReports->description = 'View reports';
        $auth->add($viewReports);

        // Create roles
        $guest = $auth->createRole('guest');
        $auth->add($guest);
        $auth->addChild($guest, $viewBooks);
        $auth->addChild($guest, $viewAuthors);
        $auth->addChild($guest, $subscribe);
        $auth->addChild($guest, $viewReports);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $guest);
        $auth->addChild($user, $manageBooks);
        $auth->addChild($user, $manageAuthors);

        $this->stdout("RBAC initialized successfully.\n");
    }
}

