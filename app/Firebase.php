<?php

namespace App;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class Firebase
{
    private $_serviceAccount;
    private $_firebase;

    public function __construct()
    {
        $this->_serviceAccount = ServiceAccount::fromJsonFile(storage_path().'/laravel-firebase-test-8a7ea-9cae29d910f8.json');
        $this->_firebase = (new Factory)->withServiceAccount($this->_serviceAccount)
                ->withDatabaseUri('https://laravel-firebase-test-8a7ea.firebaseio.com')
                ->create();
    }


    public function getServiceAccount()
    {
        return $this->_serviceAccount;
    }

    public function getInstance()
    {
        return $this->_firebase;
    }
}
