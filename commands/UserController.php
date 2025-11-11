<?php

declare(strict_types=1);

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionCreate(string $username, string $password): void
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();
        
        if ($user->save()) {
            $this->stdout("User '{$username}' created successfully.\n");
            
            // Assign user role
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            if ($userRole) {
                $auth->assign($userRole, $user->id);
                $this->stdout("Role 'user' assigned to '{$username}'.\n");
            }
        } else {
            $this->stderr("Failed to create user: " . json_encode($user->errors) . "\n");
        }
    }
}

