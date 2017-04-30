<input type="hidden" id="last_chat_id" value="<?php  echo isset($lastChatData->id) && $lastChatData->id != '' ? $lastChatData->id : 0; ?>">
<div class="convertPart" style="position: relative;">
    <div  style="position: absolute; width: 100%; bottom: 0px; height: 400px;" id="testDiv3">
        <?php
        if (isset($conversions))
            {
            foreach ($conversions as $conversions_key => $conversion)
                {
                ?>
                <div class="conversationText" id="chat_msg_<?php echo $conversion->id;?>">
                    <div class="conversationImage"><img src="<?php
                        if ($conversion->sender->profile_image)
                            {
                            echo Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $conversion->sender->profile_image;
                            }
                        else
                            {
                            echo Assets::themeUrl("images/avatarImage.jpg");
                            }
                        ?> " alt=""/></div>
                    <div class="conversationTTextt"><h3><a href="#"><?php echo $conversion->sender->username; ?></a></h3>
                        <p><?php echo $conversion->message; ?></p>
                    </div>
                    <div class="conversationDate"><p><?php echo $conversion->created_at; ?></p></div>
                </div>
                <?php
                }
            }
        ?>
    </div>
</div>