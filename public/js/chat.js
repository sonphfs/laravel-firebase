$('document').ready(function(){
    var user_receive;
    var baseUrl = window.location.protocol + "//" + window.location.host;
    arr = window.location.href.split('/');
    user_receive = arr[4];
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
                url: baseUrl + '/send-message',
                data: {
                    "msg" : msg,
                    "user_receive" : user_receive
                },
                success: function(result){
                    console.log(result);
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
    console.log(user_receive);
    $('.chat_list').click(function(e){
        user_receive = $(this).data('user');
        window.location.replace(baseUrl + '/firebase/' + user_receive);
    })

    $('.upload-file').change(function(){
        var file;
        var formData;
        if($(this).prop('files').length > 0) {
            formData =  new FormData();
            file = $(this).prop('files')[0];
            formData.append('fileUpload', file);
            formData.append('user_receive', user_receive);
            $.ajax({
                type: 'post',
                url: baseUrl + '/send-message',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result){
                    console.log(result);
                },
                error: function(result){
                    console.log(result);
                }
            });
        }
    });
});
