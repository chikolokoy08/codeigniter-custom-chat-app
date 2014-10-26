$(document).ready(function(){
    
    var baseUrl = ''+window.location.protocol+'//'+window.location.host;
    var onload = true;
    var chatBox, chatlist;
    var suid = $('#suid').html();
    var tries = 0;

    /*
    |--------------------------------------------------------------------------
    | CURRENT DATE VARIABLES
    |--------------------------------------------------------------------------
    */      
    var dt = new Date();
    var month = (dt.getMonth()+1);
    var day = dt.getDate();
    var hr = dt.getHours();
    var min = dt.getMinutes();
    var sec = dt.getSeconds();

    if(month < 10) { month = '0'+ month; }
    if(day < 10) { day = '0'+ day; }
    if(hr < 10) { hr = '0'+ hr; }
    if(min < 10) { min = '0'+ min; }
    if(sec < 10) { sec = '0'+ sec; }

    var curdate = dt.getFullYear() + "-" + month + "-" + day;   
    var curtime = hr + ":" + min + ":" + sec;       

    //Cookies
    setCookie = function(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    };    

    getCookie = function(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
        }
        return "";
    };    
    
    
    /*
    |--------------------------------------------------------------------------
    | CHAT FUNCTIONS
    |--------------------------------------------------------------------------
    */
    chatBeat = function(){

        $('#chat-container .chat-object').each(function(){
            var dis = $(this);
            if (dis.html() != '' || dis.html() != undefined) {
                var userId = $(this).attr('chatid');
                var chatlist = dis.find('.cb-feeds');
                                
                var currentstamp = chatlist.find('li:last-child').attr('timestamp');
                if(currentstamp == undefined) {
                    currentstamp = curdate + ' ' + curtime;
                }
                var chatFeeds = '/users/chat_new?id=' + userId + '&timestamp=' + currentstamp;
                $.getJSON( chatFeeds, function( data ) {
                    chatModel(data, dis);
                });
            }
        });        
    }

    prepBox = function(chatBox, dis) {

        var userId = dis.attr('chatto');
        var chatname = dis.find('#cu-email');
        var state = dis.find('.status');  

        // //Initialize to copy userid to close button
        chatBox.find('.chat-close').attr('chatto', userId);
        chatBox.find('.chatname_title').html('<a href="'+baseUrl+'/users/profile/'+chatname.html()+'">'+chatname.html()+'</a>');
        chatBox.find('[name="chat_to"]').val(userId);
        chatBox.attr('chatid', userId);

        setCookie('chatid_'+userId+'', ''+userId+'', 7);

        //To provide color effect on chat box display
        if(state.html() == 'Inactive'){
            chatBox.find('.panel').removeClass('panel-success').addClass('panel-default');
        }
        else {
            chatBox.find('.panel').removeClass('panel-default').addClass('panel-success');
        }

    }

    chatModel = function(dataGot, disObj) {

        var c = disObj;
        var disFeeds = c.find('.cb-feeds');

        if(dataGot.length > 0) {
            var items = [];
            $.each( dataGot, function( key, item ) {
                if(item.me === suid) {
                    items.push( '<li class="bg-gradient me" timestamp="'+item.timestamp+'"><span class="mb">'+item.message+'</span><small class="time">'+item.timestamp+'</small></li>' );
                } else {
                    items.push( '<li timestamp="'+item.timestamp+'" class="from"><span class="mb">'+item.message+'</span><small class="time">'+item.timestamp+'</small></li>' );
                }
            });

            disFeeds.append(items.join("")).fadeIn(1000, function(){
                disFeeds.animate({scrollTop: disFeeds.height()+1000000}, 1000);
            });
        }
    }

    chatOnLoad = function(dis) {
        dis.find('.message-box').focus();
        var userId = dis.find('#chat_to').val();
        var chatFeeds = '';
        chatFeeds = '/users/chat?id=' + userId ;
        $.getJSON( chatFeeds, function( data ) {
            chatModel(data, dis);
        });
    }
        
    chatOpener = function(obj){
        
        var dis = obj;
        var userId = dis.attr('chatto');
        var cCon = $('#chat-container');
        var cBox = $('.cb-box #chat-box');

        if(dis.hasClass('open') == false) {
            prepBox(cBox, dis);
            dis.addClass('open');
            cBox.clone().appendTo(cCon);
            chatOnLoad(cCon.find('[chatid="'+userId+'"]'));
        } else {
            promptMessage('warning', 'Users chatbox is already open');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | FOR CHAT LIST ACTIONS
    |--------------------------------------------------------------------------
    */      
    $(document).on('click', '.chatusers', function(){
        chatOpener($(this));
    });


    /*
    |--------------------------------------------------------------------------
    | FOR CHAT BOX ACTIONS
    |--------------------------------------------------------------------------
    */  
    $(document).on('click', '.chat-toggler, .chat-close', function(){
        
        var dis = $(this);
        var cBox = dis.closest('#chat-box');
        var suid = dis.attr('chatto');
        var cCon = $('.chat-container');

        if(dis.hasClass('chat-toggler') == true) {
            cBox.toggleClass('cbox-min');           
        } else {
            $('#chatgroup .chatusers[chatto="'+suid+'"]').removeClass('open');
            cBox.fadeOut(200, function(){
                cBox.remove();    
            });
        }
    });
    
    $(document).on('submit', '.chat-form', function(e){

        e.preventDefault();
        var vF = true;
        var disForm = $(this);
        var subBtn = disForm.find('#submit-chat-btn');
        var toid = disForm.find('[name="chat_to"]');
        var message = disForm.find('[name="message"]');
        var chatBox = disForm.closest('#chat-box');
        disForm.find('.required').each(function(){
            if (vF && $(this).val() == '') {
                promptMessage('error', 'This field is required');
                $(this).focus();
                vF = false;
            }
        });
     
        if(vF) {
            subBtn.addClass('disabled').attr('disabled', 'disabled');
            var actionPath = disForm.attr('action');
            var dataString = disForm.serialize();
            message.attr('disabled','disabled').addClass('disabled');
            $.ajax({
                type: 'POST',  
                url: actionPath,
                data: dataString,
                dataType: 'json',
                success: function(data, textStatus, XMLHttpRequest){
                    if (chatBox.find('.cb-feeds').html() == '' || chatBox.find('.cb-feeds').html() == undefined) {
                        chatBeat();
                    }
                    message.removeAttr('disabled').removeClass('disabled');
                    message.val('').focus();
                    subBtn.removeClass('disabled').removeAttr('disabled');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    setTimeout('window.location = "/"',500);
                }
            });
        }

    });

    $(document).on('mouseover', '#chat-container .chat-object', function(){
        $('#chat-container .chat-object').removeClass('active-mb');
        $(this).addClass('active-mb');
    });
    
    $(document).on('keypress', '.active-mb #message', function(e){
        if(e.keyCode == 13) {
            if($(this).val() == '') {
                $(this).val('').focus();
                promptMessage('warning', 'Message box is empty.');
            } else {
                $(this).closest('form').submit();
            }
        }
    });
    
    chatPulse = function(){
        
        if($('#chat-container .chat-object').length > 0) {
            console.log('has '+$('#chat-container .chat-object').length+' displayed');
            setInterval(function(){
                chatBeat();
            },3000);
        } else {
            if(tries > 50) {
                setTimeout('window.location = "/"',500);
            } else {
                tries++;
                setTimeout(function(){chatPulse();},10000);
            }
        }
    }
    chatPulse();

});
