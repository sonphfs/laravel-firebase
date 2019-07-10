<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<div id="messgesDiv">
    <center><h3>Message</h3></center>
</div>
<div style="margin-top: 20px;">
    <input class="form-control" type="text" id="nameInput" placeholder="Name">
    <input type="text" id="messageInput" placeholder="Message">
</div>
<script !src="">
    var myDataRef = new Firebase("https://laravel-firebase-test-8a7ea.firebaseio.com");
    $("#messageInput").keypress(function (e){
        if(e.keyCode == 13){ //Enter
            var name = $("#nameInput").val();
            var text = $("#messageInput").val();
            console.log(name + " -- " + text);
            myDataRef.set({key: name, value: text});
        }
    });

    myDataRef.on('child_added', function (snapshot){
        var message = snapshot.val();
        displayChatMessage(message.name, message.text);
    });

    function displayChatMessage(name, text){
        console.log(name + " -- " + text);
        $('<div/>').text(text).prepend($('<em/>').text(name+": ")).appendTo($("#messgesDiv"));
        $("#messgesDiv")[0].scrollTop = $("#messgesDiv")[0].scrollHeight;
    }
</script>
