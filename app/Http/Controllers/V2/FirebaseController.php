<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Firebase;

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

    public function firebase()
    {
        return view('v2.firebase', []);
    }

}
