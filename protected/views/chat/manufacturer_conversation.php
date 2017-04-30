<link href="<?php echo Assets::themeUrl("vendor/custom-scrollbar/jquery.mCustomScrollbar.min.css"); ?>" rel="stylesheet">
<!--<link href="<?php // echo Assets::themeUrl("css/prettify.css");              ?>" rel="stylesheet">
<link href="<?php // echo Assets::themeUrl("css/style.css");              ?>" rel="stylesheet">-->
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
<!--<script src="<?php // echo Assets::themeUrl("js/prettify.js");              ?>"></script>-->
<!--<script src="<?php // echo Assets::themeUrl("js/jquery.slimscroll.js");              ?>"></script>-->
<script src="<?php echo Assets::themeUrl("vendor/custom-scrollbar/jquery.mCustomScrollbar.js"); ?>"></script>
<script src="<?php echo Assets::themeUrl("vendor/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"); ?>"></script>
<section class="dash-box">
    <div class="color-box3">
        <div class="container">

            <div class="designerDetails detailsConvertion">
                <div class="examples">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="searchFriendsParts">
                            <div class="searchFriendss">

                                <input type="text" placeholder="Search" class="textFieldDesigner" id="search_user">
                                <button type="submit" class="searchSubmitC" onclick="search_user();"></button>

                            </div>

                            <div id="testDiv">
                                <ul>
                                    <?php
                                    if (isset($chatThreads)) {

                                        $chatThreadCount = 0;
                                        $threadActive = 'chat_thread';
                                        $activeChatThread = '';
                                        foreach ($chatThreads as $chatThreads_index => $chatThread) {
                                            $chatThreadCount = $chatThreadCount + 1;
                                           
                                                if ($chatThreadCount == 1) {
                                                    $threadActive = 'chat_thread active curr_chat';
                                                    $activeChatThread = $chatThread->id;
                                                } else {
                                                    $threadActive = 'chat_thread';
                                                }
                                          
                                            ?>
                                            <li class="<?php echo $threadActive; ?> chat_li" id="left_tab_<?php echo $chatThread->started_by; ?>" data-active_chat_master_id="<?php echo $activeChatThread; ?>" data-receiver_id="<?php echo $chatThread->started_by; ?>" data-chat_master_id="<?php echo $chatThread->id; ?>">
                                                <a href="#" class="<?php echo $threadActive; ?>"><div class="pImagep"><img src="<?php
                                                        if ($chatThread->user_by->profile_image) {
                                                            echo Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $chatThread->user_by->profile_image;
                                                        } else {
                                                            echo Assets::themeUrl("images/avatarImage.jpg");
                                                        }
                                                        ?>" alt=""/></div>
                                                    <div class="nameDesigner"><p><span class="user_left"><?php echo $chatThread->user_by->username; ?></span><span id="left_tab_count_<?php echo $chatThread->started_to; ?>"></span></p></div>
                                                    <div class="dateDesigner">Aug 10</div></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div id="testDiv2">
                            <center><img class="chat_part_loader" src="<?php echo Assets::themeUrl('images/btn_load.gif'); ?>" style="border: 0; 
                                         width: 100px;
                                         height: 100px;
                                         -webkit-box-shadow: 10px 10px 14px -11px rgba(0,0,0,0) !important; 
                                         -moz-box-shadow: 10px 10px 14px -11px rgba(0,0,0,0) !important;
                                         box-shadow: 10px 10px 14px -11px rgba(0,0,0,0) !important;   
                                         margin: 25% auto 0 auto;                              
                                         "/></center>
                            <div class="mainAppendArea" >

                            </div>
                        </div>
                        <div class="replyPart">
                            <form id="main_chat_form">
                                <input type="hidden" id="heartbeat_status" name="heartbeat_status" value="yes"/>
                                <input type="hidden" id="current_chat_thread" name="chat_master_id" value="" data-current_chat_master_id="">
                                <input type="hidden" id="receiver_id" name="ChatInbox[receiver_id]" value="" >
                                <input type="hidden" id="last_chat_index" name="last_chat_index" value=""/>
                                <textarea class="textareaConversation" name="ChatInbox[message]" placeholder="Write a reply"></textarea>
                                <button type="submit"  id="main_chat_form_submit" class="submitConvert">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </div><!--color-box3-->
</section>
<script type="text/javascript">

    //enable syntax highlighter
//    prettyPrint();
//
//    var _gaq = _gaq || [];
//    _gaq.push(['_setAccount', 'UA-3112455-22']);
//    _gaq.push(['_setDomainName', 'none']);
//    _gaq.push(['_trackPageview']);
//
//    (function() {
//        var ga = document.createElement('script');
//        ga.type = 'text/javascript';
//        ga.async = true;
//        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
//        var s = document.getElementsByTagName('script')[0];
//        s.parentNode.insertBefore(ga, s);
//    })();

    $(document).ready(function() {

      //     setInterval('chatHeartbeat();', 1000);




        var chat_master_id = $('.curr_chat').eq(0).data('chat_master_id');
        var receiver_id = $('.curr_chat').eq(0).data('receiver_id');

        if (typeof (receiver_id !== 'undefined')) {
            $('#current_chat_thread').val(chat_master_id);
            $('#receiver_id').val(receiver_id);
        }
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: {chat_master_id: chat_master_id, receiver_id: receiver_id},
            dataType: "json",
            url: "<?php echo Yii::app()->createAbsoluteUrl('chat/AppendChatData'); ?>",
            success: function(data) {

                $('.chat_part_loader').hide();
                if (data.type == 'success') {
                    $('.mainAppendArea').append(data.html);
                    $("#last_chat_index").val(data.last_chat_index);
                    if ($("#testDiv3").find(".mCSB_container").length > 0) {
                        $("#testDiv3").mCustomScrollbar("update");
                        $("#testDiv3").mCustomScrollbar("scrollTo", "bottom");
                    } else {
                        $("#testDiv3").mCustomScrollbar();
                        $("#testDiv3").mCustomScrollbar("scrollTo", "bottom");
                    }
//                      $(selector).mCustomScrollbar("update");
//                    window.location.href = "<?php // echo Yii::app()->createUrl('/chat/appendChatData');               ?>";
                }
            }
        });


        $("#search_user").keyup(function(e) {
            e.preventDefault();

            search_user();
        });


    });

    $('.chat_thread').on('click', function(e) {
        e.preventDefault();
        $('.chat_part_loader').show();
        $(".mainAppendArea").hide();
        var _this = $(this);
        $("#testDiv").find(".chat_thread").removeClass("active");
        _this.addClass("chat_thread active");
        var chat_master_id = '';
        if (typeof (_this.closest('li').data('chat_master_id') !== 'undefined')) {
            chat_master_id = _this.closest('li').data('chat_master_id')
            $('#current_chat_thread').val(_this.closest('li').data('chat_master_id'));
            $('#receiver_id').val(_this.closest('li').data('receiver_id'));
        }
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: {chat_master_id: chat_master_id},
            dataType: "json",
            url: "<?php echo Yii::app()->createAbsoluteUrl('chat/AppendChatData'); ?>",
            success: function(data) {
                $('.chat_part_loader').hide();
                $(".mainAppendArea").show();
                if (data.type == 'success') {
                    $('.mainAppendArea').html(data.html);
                    $("#last_chat_index").val(data.last_chat_index);

                    if ($("#testDiv3").find(".mCSB_container").length > 0) {
                        $("#testDiv3").mCustomScrollbar("update");
                        $("#testDiv3").mCustomScrollbar("scrollTo", "bottom");
                    } else {
                        $("#testDiv3").mCustomScrollbar();
                        $("#testDiv3").mCustomScrollbar("scrollTo", "bottom");
                    }

                }
            }
        });
    });

    $('form#main_chat_form').on('submit', function(e) {
        e.preventDefault();
        var lastChatId = $('#last_chat_id').val();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: $('#main_chat_form').serialize(),
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('/chat/doChat'); ?>" + '?lastChatId=' + lastChatId,
            success: function(data) {
                // $('.chat_part_loader').hide();
                if (data.type == 'success') {

                    $(".textareaConversation").val('');
                    chatHeartbeat();
                    // $('.mainAppendArea').html(data.html);
//                    window.location.href = "<?php // echo Yii::app()->createUrl('/chat/appendChatData');               ?>";
                }
            }
        });


    });

    function chatHeartbeat() {
        if ($("#heartbeat_status").val() == "yes" && $("#last_chat_index").val() != "") {
            $("#heartbeat_status").val('no');

            var chat_master_id = $("#current_chat_thread").val();
            var receiver_id = $("#receiver_id").val();
            var last_chat_index = $("#last_chat_index").val();

            $.post("<?php echo Yii::app()->createUrl('/chat/GetChatMsg'); ?>",
                    {
                        chat_master_id: chat_master_id,
                        receiver_id: receiver_id,
                        last_chat_index: last_chat_index
                    },
            function(resp) {

                if (resp.type == "success") {

                    $.each(resp.chat_list, function(index, elem) {

                        //   if ($("#chat_msg_" + elem.id).length == 0) {
                        var html = "";
                        html = '<div class="conversationText" id="chat_msg_' + elem.id + '">' +
                                '<div class="conversationImage">' +
                                '<img src="' + elem.profile_picture + '" alt=""/></div>' +
                                '<div class="conversationTTextt"><h3><a href="#">' + elem.username + '</a></h3>' +
                                '<p>' + elem.message + '</p>' +
                                '</div>' +
                                '<div class="conversationDate"><p>' + elem.time + '</p></div>' +
                                '</div>';
                        //  $("#testDiv3").find(".convertPart").children('div').append(html);
                        $("#testDiv3").find('.mCSB_container').append(html);
                        //    }




                    });

                    $("#last_chat_index").val(resp.last_index);

                    $.each(resp.user_msg, function(index, elem) {
                        if (elem.total > 0) {

                            $("#left_tab_count_" + elem.id).html("(" + elem.total + ")");
                        }
                    });



                    if ($("#testDiv3").find(".mCSB_container").length > 0) {
                        $("#testDiv3").mCustomScrollbar("update");
                        $("#testDiv3").mCustomScrollbar("scrollTo", "bottom");
                    } else {
                        $("#testDiv3").mCustomScrollbar();
                        $("#testDiv3").mCustomScrollbar("scrollTo", "bottom");
                    }
                }

                $("#heartbeat_status").val('yes');

            }, 'json');
        }
    }


    function search_user() {

        var text = $("#search_user").val().toLowerCase();
        if (text.length > 0) {
            $(".chat_li").hide();
            $.each($(".user_left"), function(index, elem) {
                var test_text = $(elem).text().toLowerCase();

                var n = test_text.search(text);

                if (n != -1) {
                    $(elem).closest('.chat_li').show();
                }
            });
        } else if (text.length == 0) {
            $(".chat_li").show();
        }
    }


</script>

