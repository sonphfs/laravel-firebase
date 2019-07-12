<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use App\User;

class FirebaseController extends Controller
{
    private $_serviceAccount;
    private $_firebase;
    private $_database;
    private $_auth;

    public function __construct()
    {
        $this->_serviceAccount = ServiceAccount::fromJsonFile(storage_path().'/laravel-firebase-test-8a7ea-9cae29d910f8.json');
        $this->_firebase = (new Factory)->withServiceAccount($this->_serviceAccount)
                ->withDatabaseUri('https://laravel-firebase-test-8a7ea.firebaseio.com')
                ->create();
        $this->_auth = $this->_firebase->getAuth();
        $this->_database = $this->_firebase->getDatabase();
    }

    public function index()
    {
        $newPost = $this->_database->getReference('blog/posts')->push(['title'=>'Post title', 'body'=>'This should probably be longer']);

        return \response()->json($newPost->getValue());
    }

    public function firebaseClient()
    {
        $token = $this->_generateToken(1);
        return view('firebase', ['token' => $token]);
    }

    public function createUser()
    {
        $userProperties = [
            'email' => 'sonph1@gmail.com',
            'emailVerified' => false,
            'phoneNumber' => '+15555550101',
            'password' => 'admin123',
            'displayName' => 'son ph1',
            'photoUrl' => 'http://www.example.com/12345678/photo.png',
            'disabled' => false,
        ];
        $createdUser = $this->_firebase->getAuth()->createUser($userProperties);

        return \response()->json($createdUser);
    }

    public function createUserById()
    {
        $user = User::find(1);
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
        $createdUser = $this->_firebase->getAuth()->createUser($userProperties);

        return \response()->json($createdUser);
    }

    public function updateUser($id)
    {
        // fields update
        $properties = [
            'displayName' => 'Sonph go pro'
        ];
        $updateUser = $this->_firebase->getAuth()->updateUser($id, $properties);
    }

    public function getListUsers()
    {
        $users = $this->_auth->getListUsers($defaultMaxresults = 1000, $defaultBatchSize = 1000);

        return \response()->json($users);
    }

    public function getUserInfo($id)
    {
        $user = $this->_auth->getUser($id);

        return \response()->json($user);

    }

    private function _hasUserOnFirebase($uid)
    {
        if($this->_auth->getUser($uid))
            return true;
        return false;
    }

    private function _generateToken($uid)
    {
        $additionalClaims = [
            'premiumAccount' => true
        ];
        $customToken = $this->_auth->createCustomToken($uid, $additionalClaims);
        $customTokenString = (string) $customToken;

        return $customTokenString;
    }

    private function _hasData($data)
    {
        if(empty($data) || !isset($data))
            return false;
        return true;
    }
}
