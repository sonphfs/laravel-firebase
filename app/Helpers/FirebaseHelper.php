<?php

namespace App\Helpers;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class FirebaseHelper
{
    public static function getAllUser($auth)
    {
        $users = $auth->listUsers($defaultMaxresults = 1000, $defaultBatchSize = 1000);
        $data = [];
        foreach ($users as $key =>  $user) {
            $data[$user->email]['id'] = $user->uid;
            $data[$user->email]['displayName'] = $user->displayName;
        }
        return $data;
    }

    public static function checkUserOnFirebase($auth, $email)
    {
        $listUsers = self::getAllUser($auth);
        if(empty($listUsers[$email])) {
            return false;
        }
        return true;
    }
}
