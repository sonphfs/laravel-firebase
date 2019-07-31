<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Firebase;
use App\Helpers\FirebaseHelper;
use Auth;
use App\User;

class FirebaseController extends Controller
{
    private $_serviceAccount;
    private $_firebase;
    private $_database;
    private $_auth;

    public function __construct(Firebase $firebase)
    {
        $this->_firebase = $firebase->getInstance();
        $this->_auth = $this->_firebase->getAuth();
        $this->_database = $this->_firebase->getDatabase();
    }

    public function index()
    {
        $newPost = $this->_database->getReference('blog/posts')->push(['title'=>'Post title', 'body'=>'This should probably be longer']);

        return \response()->json($newPost->getValue());
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

    public function group()
    {
        $userId = Auth::id();
        FirebaseHelper::createUser(Auth::user(), $this->_database);
        $token = $this->_generateToken($userId);
        return view('v1.firebase', ['token' => $token, 'key' => 'groups']);
    }

    public function addMember(Request $request)
    {
        $userId = $request['userId'];
        FirebaseHelper::addUserToGroupChat($userId, '-Ll0tPepnhYoDsfV3WQz', $this->_database);
    }

    public function sendMessageGroup(Request $request)
    {
        $newMessage = $request['msg'];
        $groupId = $request['groupId'];
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
            $sendData = $this->_sendMessageToFirebase($fileName , $groupId, $this->_database, true);
            return response()->json($sendData);
        }
        if(!empty($request['msg'])){

            $sendData = $this->_sendMessageToFirebase($newMessage , $groupId, $this->_database);
            return \response()->json($sendData);
        }
        return \response()->json('final');
    }

    private function _sendMessageToFirebase($message, $groupId, $database, $sendFile = false)
    {
        $user_send = Auth::id();
        $data = [];
        if($sendFile) {
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

    public function log()
    {
        dd(FirebaseHelper::getListGroup(1, $this->_database));
    }
}
