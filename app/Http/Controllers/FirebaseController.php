<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use App\User;
use Auth;
use App\Helpers\FirebaseHelper;

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

    private function _initialFirebaseUser()
    {
        $userId = Auth::id();
        $email = Auth::user()->email;
        if(!FirebaseHelper::checkUserOnFirebase($this->_auth, $email)) {
            $this->_createUserById($userId);
        }
    }

    public function index()
    {
        $newPost = $this->_database->getReference('blog/posts')->push(['title'=>'Post title', 'body'=>'This should probably be longer']);

        return \response()->json($newPost->getValue());
    }

    public function firebaseClient($id)
    {
        $userId = Auth::id();
        $this->_initialFirebaseUser();
        $users = $this->_getlistUsers();
        $token = $this->_generateToken($userId);
        $key = $this->_getFirebaseDataKey($id, $userId);
        return view('firebase', ['token' => $token, 'users' => $users, 'key' => $key]);
    }

    public function sendMessage(Request $request)
    {
        $newMessage = $request['msg'];
        $user_receive = $request['user_receive'];
        if($request->hasFile('fileUpload')) {
            $data = [];
            $file = $request->fileUpload;
            $data = [
                'file_name' => $file->getClientOriginalName(),
                'ets' =>  $file->getClientOriginalExtension(),
                'name' => $file->getFileName(),
                'path' => $file->getRealPath(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType()
            ];
            $path = 'uploads';
            $fileName = $file->getFileName().'.'.$file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $sendData = $this->_sendMessageToFirebase($fileName , $user_receive, true);
            return response()->json($sendData);
        }
        if(!empty($request['msg'])){
            $sendData = $this->_sendMessageToFirebase($newMessage , $user_receive);
            return \response()->json($sendData);
        }
        return \response()->json(['status' => 'Failed!']);
    }

    private function _getFirebaseDataKey($user_receive, $userId)
    {
        $key = "";
        if($user_receive == 'ChatRoom') {
            $key = "ChatRoom";
        } else {
            if($userId > $user_receive)
                $key = 'Messages/' . $userId . '_' . $user_receive;
            $key = 'Messages/' . $user_receive . '_' . $userId;
        }
        return $key;
    }

    private function _sendMessageToFirebase(string $newMessage, $user_receive, $send_file = false)
    {
        $user_send = Auth::id();
        if($send_file) {
            $data = [
                'user_id' => $user_send,
                'file_name' => $newMessage,
                'time' => time() * 1000
            ];
        } else {
            $data = [
                'user_id' => $user_send,
                'message' => $newMessage,
                'time' => time() * 1000
            ];
        }
        $key = $this->_getFirebaseDataKey($user_receive, $user_send);
        $sendData = $this->_database->getReference($key)->push($data);

        return \response()->json($sendData->getValue());
    }

    public function loadMessageFromFirebase()
    {
        $lastMessage = request()->lastMessage;
        $messages = $this->_database->getReference('ChatRoom')->getSnapshot()->getValue();
        if(!empty($messages)) {
            return  array_reverse($messages, true);
        }
        return "failed";
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

    public function createUserById($id)
    {
        return $this->_createUserById($id);
    }

    private function _createUserById($id)
    {
        $user = User::find($id);
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
        $users = $this->_getlistUsers();
        return $users;
    }

    private function _getlistUsers()
    {
        $users = $this->_auth->listUsers($defaultMaxresults = 1000, $defaultBatchSize = 1000);
        $data = [];
        foreach ($users as $key =>  $user) {
            $data[$key]['id'] = $user->uid;
            $data[$key]['displayName'] = $user->displayName;
            $data[$key]['email'] = $user->email;
        }
        return $data;
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

    public function logout()
    {
        Auth::logout();
        return \redirect('/firebase');
    }

    public function testClient()
    {
        return view('firebase-client');
    }
}
