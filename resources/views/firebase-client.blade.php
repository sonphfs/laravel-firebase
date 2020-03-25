<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!-- Add Firebase products that you want to use -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://serene-eyrie-27492.herokuapp.com/css/chat-template.css" type="text/css">
    <script src="https://serene-eyrie-27492.herokuapp.com/v1/js/chat.js"></script>

    <script src="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.css" />
<!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

  <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/6.3.1/firebase-app.js"></script>

  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/6.3.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/6.3.1/firebase-firestore.js"></script>
  {{-- <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-auth.js"></script> --}}
<script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script>
</body>
</head>
<body>
    <div id="messgesDiv">
        <h1 style="text-align: center">Heroku</h1>
    </div>
    <div class="container">
            <h3 class=" text-center">Messaging</h3>
            <div class="messaging">
                  <div class="inbox_msg">
                    <div class="inbox_people">
                    </div>
                    <div class="mesgs" style="width: 100%;">
                      <div class="msg_history">
                      </div>
                      <div class="type_msg">
                        <div class="input_msg_write">
                          <input id="chat-msg" type="text" class="write_msg" placeholder="Type a message" />
                          <button id="send-msg-btn" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p>
                </div>
                <div style="text-align: center; margin-bottom: 50px;"><button class="btn" onclick="logout()">Logout Chatroom</button></div>
            </div>
    <script>
        let email = "sonph@kaopiz.com";
        let password = "admin123";
        const firebaseConfig = {
                apiKey: "AIzaSyAYbwvoI-Qzw1p_yfeH6xGqzwHB6B8LRhM",
                authDomain: "laravel-firebase-test-8a7ea.firebaseapp.com",
                databaseURL: "https://laravel-firebase-test-8a7ea.firebaseio.com",
                projectId: "laravel-firebase-test-8a7ea",
                storageBucket: "",
                messagingSenderId: "379128692585",
                appId: "1:379128692585:web:caf48780a7c4aeb1"
            };
            firebase.initializeApp({
                apiKey: firebaseConfig.apiKey,
                authDomain: "laravel-firebase-test-8a7ea.firebaseapp.com",
                databaseURL: "https://laravel-firebase-test-8a7ea.firebaseio.com",
                storageBucket: "",
            });
        // firebase.auth().createUserWithEmailAndPassword(email, password).catch(function(error) {
        //     // Handle Errors here.
        //     var errorCode = error.code;
        //     var errorMessage = error.message;
        //     // ...
        // });
        // firebase.auth().onAuthStateChanged((user) => {
        //         if (user) {
        //             var uid = firebase.auth().currentUser.uid;
        //             var displayName = firebase.auth().currentUser.displayName;
        //             //writeNewPost(uid, displayName, null,"title hell33o222", "body-he333ll22o");
        //         } else {
        //             // User not logged in or has just logged out.
        //         }
        //     });
        function writeNewPost(uid, username, picture, title, body) {
            // A post entry.
            var postData = {
                author: username,
                uid: uid,
                body: body,
                title: title,
                starCount: 0,
                authorPic: picture
            };

            // Get a key for a new Post.
            var newPostKey = firebase.database().ref().child('chatroom').push().key;

            // Write the new post's data simultaneously in the posts list and the user's post list.
            var updates = {};
            updates['/chatroom/' + newPostKey] = postData;
            updates['/user-posts/' + uid + '/' + newPostKey] = postData;

            return firebase.database().ref().update(updates);
        }
        writeNewPost('id', 'sonph', 'pictrue', 'tite', 'ba dy');

    </script>
</body>
</html>

