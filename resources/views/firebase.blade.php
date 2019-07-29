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
    <script src="<?php echo asset('js/chat.js')?>"></script>
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
                        <div class="chat_list active_chat" data-user="ChatRoom">
                          <div class="chat_people">
                            <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                            <div class="chat_ib">
                            <h5> General <span class="chat_date">{{ date("Y/m/d") }}</span></h5>
                              <p>Ren nơ rồ</p>
                            </div>
                          </div>
                        </div>
                        @foreach ($users as $user)
                            @if($user['id'] != Auth::id())
                                <div class="chat_list" data-user="{{ $user['id'] }}">
                                    <div class="chat_people">
                                    <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                    <div class="chat_ib">
                                        <h5>{{ $user['displayName'] }} <span class="chat_date">Dec 25</span></h5>
                                        <p>Test, which is a new approach to have all solutions
                                        astrology under one roof.</p>
                                    </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                      </div>
                    </div>
                    <div class="mesgs">
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
            <input type="hidden" data-token="{{$token}}">
            <input class="key-fr" type="hidden" data-key="{{$key}}">
    <script>
        (function(){
            var token = $('input[type="hidden"]').data('token');
            var key = $('.key-fr').data('key');
            console.log(key);
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
                    //writeNewPost(uid, displayName, null,"title hell33o222", "body-he333ll22o");
                } else {
                    // User not logged in or has just logged out.
                }
            });
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

            var starCountRef = firebase.database().ref(key);
            var page = 1;
            var per_page = 2;
            var lastKey = 'aa';
            var lazyLoadingMessage = function(messages, currentId) {
                messages = messages.reverse();
                messages.forEach(function(data){
                    var outgoing_msg;
                    var incoming_msg;
                    if(currentId == data.user_id){
                        outgoing_msg = `<div class="outgoing_msg">
                                            <div class="sent_msg">
                                            <p>` + data.message + `
                                            <span class="time_date"> ` + getTime(data.time) + `     |` + isToday(data.time) +`</span> </div>
                                        </div>`;
                        $('.msg_history').prepend(outgoing_msg);
                    }
                    else {
                        incoming_msg = `<div class="incoming_msg">
                                            <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p>` + data.message + `</p>
                                                <span class="time_date"> ` + getTime(data.time) + `     | ` + isToday(data.time) +`</span>
                                                </div>
                                            </div>
                                        </div>`;
                        $('.msg_history').prepend(incoming_msg);
                    }
                });
            }

            var renderMessages = async function(){
                var arrMessages = Array();
                var currentId;
                var query;
                if(lastKey){
                    query = starCountRef.orderByKey().endAt(lastKey).limitToLast(per_page);
                } else {
                    query = starCountRef.orderByKey().limitToLast(per_page);
                }
                starCountRef.on('child_added', function(snapshot) {
                    currentId = firebase.auth().currentUser.uid;
                    var data = snapshot.val();
                    arrMessages.push(data);
                    displayMessage(data, currentId);
                    // ref.off();
                });
                console.log(arrMessages);
                lazyLoadingMessage(arrMessages, currentId);
            }

            renderMessages();

            var displayMessage = function(data, currentId){
                var outgoing_msg;
                var incoming_msg;
                if(currentId == data.user_id){
                    outgoing_msg = `<div class="outgoing_msg">
                                        <div class="sent_msg">
                                        <p>` + data.message + `
                                        <span class="time_date" style="color: #EEE">` + getTime(data.time) + isToday(data.time) +`</span> </div>
                                    </div>`;
                    $('.msg_history').append(outgoing_msg);
                }
                else {
                    incoming_msg = `<div class="incoming_msg">
                                        <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                            <div class="received_msg">
                                                <div class="received_withd_msg">
                                                    <p>` + data.message + `</p>
                                            <span class="time_date"> ` + getTime(data.time) + isToday(data.time) +`</span>
                                            </div>
                                        </div>
                                    </div>`;
                    $('.msg_history').append(incoming_msg);
                }
                $('.msg_history')[0].scrollTop = $('.msg_history')[0].scrollHeight;
            }

            var loadingMessage = function(data, currentId) {
                var outgoing_msg;
                var incoming_msg;
                if(currentId == data.user_id){
                    outgoing_msg = `<div class="outgoing_msg">
                                        <div class="sent_msg">
                                        <p>` + data.message + `
                                        <span class="time_date" style="color: #EEE"> ` + getTime(data.time) + isToday(data.time) +`11</span> </div>
                                    </div>`;
                    $('.msg_history').prepend(outgoing_msg);
                }
                else {
                    incoming_msg = `<div class="incoming_msg">
                                        <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                            <div class="received_msg">
                                                <div class="received_withd_msg">
                                                    <p>` + data.message + `</p>
                                            <span class="time_date"> ` + getTime(data.time) + isToday(data.time) +`</span>
                                            </div>
                                        </div>
                                    </div>`;
                    $('.msg_history').prepend(incoming_msg);
                }
            }
        })();

        var newMessage = function() {
            firebase.database().ref('ChatRoom').orderByKey().limitToLast(1).on('child_added',function(snapshot) {
                console.log('new record', snapshot.val().message);
                return snapshot.val();
            });
        }
        var logout = function(){
            firebase.auth().signOut().then(function() {
                console.log('Sign-out successful.');
                window.location.replace('/logout');
                }, function(error) {
                // An error happened.
            });
        }
        var isToday = function(timetamp){
            var date = new Date(timetamp);
            var today = new Date();
            return date.getDate() == today.getDate() && date.getMonth() == today.getMonth() && date.getFullYear() == today.getFullYear() ? "   |  Today" : "";
        }

        var getTime = function(timetamp) {
            var date = new Date(timetamp);
            return date.getHours() + ":" + date.getMinutes();
        }
        </script>
</body>
</html>

