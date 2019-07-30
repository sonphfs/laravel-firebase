<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Configuration;
use Kreait\Firebase\Firebase;

class FirebaseOldController extends Controller
{
    private $_config;

    private $_firebase;

    public function __construct()
    {
        $this->_config = new Configuration();
        $this->_config->setAuthConfigFile(storage_path().'/laravel-firebase-test-8a7ea-9cae29d910f8.json');
        $this->_firebase = new Firebase('https://laravel-firebase-test-8a7ea.firebaseio.com', $this->_config);
    }

    public function index()
    {
        $data = $this->_firebase->get('/ChatRoom');
        $this->_firebase->set('vcl', 'value111');
        dd($data);
    }
}
