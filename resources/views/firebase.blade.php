<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
    <script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-firestore.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('css/chat-template.css')?>" type="text/css">
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
                      <div class="headind_srch">
                        <div class="recent_heading">
                          <h4>Recent</h4>
                        </div>
                        <div class="srch_bar">
                          <div class="stylish-input-group">
                            <input type="text" class="search-bar"  placeholder="Search" >
                            <span class="input-group-addon">
                            <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                            </span> </div>
                        </div>
                      </div>
                      <div class="inbox_chat">
                        <div class="chat_list active_chat">
                          <div class="chat_people">
                            <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                            <div class="chat_ib">
                              <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                              <p>Test, which is a new approach to have all solutions
                                astrology under one roof.</p>
                            </div>
                          </div>
                        </div>
                        <div class="chat_list">
                          <div class="chat_people">
                            <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                            <div class="chat_ib">
                              <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                              <p>Test, which is a new approach to have all solutions
                                astrology under one roof.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mesgs">
                      <div class="msg_history">
                        <div class="outgoing_msg">
                          <div class="sent_msg">
                            <p>Apollo University, Delhi, India Test</p>
                            <span class="time_date"> 11:01 AM    |    Today</span> </div>
                        </div>
                        <div class="incoming_msg">
                          <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                          <div class="received_msg">
                            <div class="received_withd_msg">
                              <p>We work directly with our designers and suppliers,
                                and sell direct to you, which means quality, exclusive
                                products, at a price anyone can afford.</p>
                              <span class="time_date"> 11:01 AM    |    Today</span></div>
                          </div>
                        </div>
                      </div>
                      <div class="type_msg">
                        <div class="input_msg_write">
                          <input type="text" class="write_msg" placeholder="Type a message" />
                          <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p>
                </div></div>
                <div style="text-align: center"><button class="btn" onclick="logout()">Logout Chatroom</button></div>
            <input type="hidden" data-token="{{$token}}">
    <script>
        (function(){
            var token = $('input[type="hidden"]').data('token');
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

            firebase.auth().signInWithCustomToken(token) // token này được truyền từ server xuống client (từ file blade của Laravel vào file js)
                .then(function () {
                    console.log('Đăng nhập thành công');
                })
                .catch(function(error) {
                    if (error.code === 'auth/invalid-custom-token') {
                        console.log('Hết hạn đăng nhập');
                    } else {
                        console.log('Lỗi xác thực');
                    }
            });
            firebase.auth().onAuthStateChanged((user) => {
                if (user) {
                    var uid = firebase.auth().currentUser.uid;
                    var displayName = firebase.auth().currentUser.displayName;
                    writeNewPost(12322, 'trunng', null,"title hell33o222", "body-he333ll22o");
                } else {
                    // User not logged in or has just logged out.
                    console.log(123);
                }
            });
            $('.msg_send_btn').click(function(){
                writeNewPost(12322, 'trunng', null,"title hell33o222", "body-he333ll22o");
            })
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
        })();
        var logout = function(){
            firebase.auth().signOut().then(function() {
                console.log('Sign-out successful.');
                }, function(error) {
                // An error happened.
            });
        }
        </script>
</body>
</html>

