$('document').ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $('#chat-msg').keypress(function(){
        let keycode = event.which;
        var baseUrl = window.location.protocol + "//" + window.location.host;
        if(keycode == '13'){
            let msg = $('#chat-msg').val();
            $('#chat-msg').val('');
            $.ajax({
                type: 'post',
                url: baseUrl + '/send-message',
                data: {
                    "msg" : msg
                },
                success: function(result){
                    console.log('OK');
                }
            });
        }
    });
    var lastScrollTop = 0;
    $('.msg_history').on('scroll', function(e){
        st = $(this).scrollTop();
        if(st == 0) {
            console.log('up 1');
        }
        else {
            // console.log('down 1');
        }
    });
});
