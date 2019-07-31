<?php

namespace App\Helpers;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use App\User;

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

    public static function createUser($user, $database)
    {
        $data = $database->getReference('users/'.$user->id)->getSnapshot()->getValue();
        if(empty($data)) {
            $userProperties = [
                'uid' => $user->id,
                'email' => $user->email,
                'emailVerified' => false,
                'phoneNumber' => $user->phone,
                'password' => $user->password,
                'displayName' => $user->name,
                'photoUrl' => 'http://www.example.com/12345678/photo.png',
                'disabled' => false,
            ];
            $database->getReference('users/'.$user->id)->set($userProperties);
        }
    }
    public static function createNewGroup($userId, $database)
    {
        $user = User::find($userId);
        $groupInfo = [
            'group_name' => '',
            'members' => [
                $user['id'] => $user['name']
            ],
            'creator' => $user->name,
            'time' => time() * 1000,

        ];
        $newGroup = $database->getReference('groups')->push($groupInfo);

        return $newGroup;
    }

    public static function addUserToGroupChat($userId, $groupId, $database)
    {

        if(!empty($user) && !self::isMemberOfGroup($userId, $groupId, $database)) {
            $database->getReference('groups/'.$groupId.'/members')->set([$userId => $user['name']]);
        }
    }

    public static function isMemberOfGroup($userId, $groupId, $database)
    {
        $isMember = $database->getReference('groups/'.$groupId.'/members'.'/'.$userId)->getSnapshot()->getValue();
        if(!empty($isMember)) {
            return true;
        }
        return false;
    }

    public static function getListGroup($userId, $database)
    {
        $groups = $database->getReference('groups')->getSnapshot()->getValue();
        $listGroups = [];
        if($groups) {
            foreach($groups as $key => $group) {
                // dd($group['members']);
                if(isset($group['members'][$userId])) {
                    $listGroups[$key] = $group['group_name'];
                }
            }
        }
        return $listGroups;
    }

    public static function sendMessageToFirebase($message, $groupId, $database, $sendFile = false)
    {

        // $user_send = Auth::id();
        return response()->json($message);

        if($send_file) {
            $data = [
                'user_send' => $user_send,
                'file_name' => $message,
                'time' => time() * 1000
            ];
        } else {
            $data = [
                'user_send' => $user_send,
                'content' => $message,
                'time' => time() * 1000
            ];
        }
        $key = 'groups/'.$groupId.'/messages';

        $sendData = $database->getReference($key)->push($data);

        return \response()->json($sendData->getValue());
    }
}
