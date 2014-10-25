$(document).ready(function(){

    //Form Processor
    $(document).on('submit', '.class-forms', function(e) {
        e.preventDefault();
        var dis = $(this);
        var rI = dis.find('.required');
        var vF = true;

        rI.each(function(){
            if (vF && $(this).val() == '') {
                promptMessage('error', 'Fill empty required fields.');
                $(this).focus();
                vF = false;
            } 
        });

        if (vF) {
            promptMessage('info', 'Loading...');
            var dataString = dis.serialize();
            var urlPath = dis.attr('action');
            $.ajax({
                type: 'POST',
                url: urlPath,
                data: dataString,
                dataType: 'json',
                success: function(data, textStatus, XMLHttpRequest){
                    if(data.status == 'success') {
                        dis.find('input[type="text"], input[type="email"], input[type="password"]').val('');
                    }
                    if(data.redirect) {
                        setTimeout('window.location = "'+data.redirect+'"',500);
                    }
                    promptMessage(data.status, data.message);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    //setTimeout('window.location = "/"',500);
                }

            });             

        }
    });

    promptMessage = function(t, m, d) {

        var p = $('body .pcprompt');

        if (p.html() == undefined) {
            var promptScript = '<div class="pcprompt alert alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span id="message"><strong>Warning!</strong> Better check yourself, you\'re not looking too good.</span></div>'
            $(promptScript).appendTo($('body'));
            var p = $('body .pcprompt');
            createMessage(p, t, m, d);
        } else {
            createMessage(p, t, m, d);    
        }
    };

    createMessage = function(prompt, type, message, dismiss){

        var messageDiv = prompt.find('#message');
        var messageOutput = '';
        var alertType = '';
        if (type == 'error') {
            alertType = 'danger';
            messageOutput = '<strong>Error!</strong> '+message+'';
        } else if (type == 'warning') {
            alertType = 'warning';
            messageOutput = '<strong>Warning!</strong> '+message+'';
        } else if (type == 'info') {
            alertType = 'info';
            messageOutput = '<strong>Attention!</strong> '+message+'';
        } else if (type == 'success') {
            alertType = 'success';
            messageOutput = '<strong>Success!</strong> '+message+'';
        }
        prompt.removeClass('alert-warning').removeClass('alert-danger').removeClass('alert-info').removeClass('alert-success');
        prompt.addClass('alert-'+alertType+'');
        messageDiv.html(messageOutput);
        prompt.slideDown(200, function(){
            setTimeout(function(){
                if(prompt.html() != undefined) {
                    prompt.slideUp();
                }
            }, 15000);
        });        

    }

});