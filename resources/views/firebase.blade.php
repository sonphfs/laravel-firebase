<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-firestore.js"></script>
<div id="messgesDiv">
    <center><h3>Message</h3></center>
</div>
<div style="margin-top: 20px;">
    <input class="form-control" type="text" id="nameInput" placeholder="Name">
    <input type="text" id="messageInput" placeholder="Message">
    <input type="hidden" data-token="{{$token}}">
</div>
<script>
$('document').ready(function(){
    var token = $('input[type="hidden"]').data('token');
    console.log(1231);
});
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
        alert('Đăng nhập thành công');
    })
    .catch(function(error) {
        if (error.code === 'auth/invalid-custom-token') {
            alert('Hết hạn đăng nhập');
        } else {
            alert('Lỗi xác thực');
        }
});
</script>
