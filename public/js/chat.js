$('document').ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $('#chat-msg').keypress(function(){
        let keycode = event.which;
        if(keycode == '13'){
            let msg = $('#chat-msg').val();
            $('#chat-msg').val('');
            $.ajax({
                type: 'post',
                url: 'http://127.0.0.1:8001/send-message',
                data: {
                    "msg" : msg
                },
                success: function(result){
                    console.log('OK');
                }
            });
        }
    });
});
