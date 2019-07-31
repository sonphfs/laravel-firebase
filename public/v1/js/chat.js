
$('document').ready(function(){
    var key = $('.key-fr').data('key');
    var baseUrl = window.location.protocol + "//" + window.location.host;
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
                url: baseUrl + '/firebase-v1/send-message-group',
                data: {
                    "msg" : msg,
                    "groupId" : key
                },
                success: function(result){
                    console.log(result);
                }
            });
        }
    });
    $('.upload-file').change(function(){
        var file;
        var formData;
        if($(this).prop('files').length > 0) {
            formData =  new FormData();
            file = $(this).prop('files')[0];
            formData.append('fileUpload', file);
            formData.append('groupId', key);
            $.ajax({
                type: 'post',
                url: baseUrl + '/firebase-v1/send-message-group',
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
