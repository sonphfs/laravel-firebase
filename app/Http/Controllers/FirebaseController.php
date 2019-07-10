<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class FirebaseController extends Controller
{
    public function index()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(storage_path().'/laravel-firebase-test-8a7ea-9cae29d910f8.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://laravel-firebase-test-8a7ea.firebaseio.com')
        ->create();
        $database = $firebase->getDatabase();
        $newPost = $database->getReference('blog/posts')->push(['title'=>'Post title', 'body'=>'This should probably be longer']);

        return \response()->json($newPost->getValue());
    }
}
