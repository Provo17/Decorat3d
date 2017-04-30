<!--<div class="left-nav">
    <img src="<?php
$userData = UserMaster::model()->findByPk(Yii::app()->user->id);

if ($userData->profile_image)
    {
    echo Yii::app()->baseUrl . '/upload/usersImage/' . $userData->profile_image;
    }
else
    {
    echo Assets::themeUrl("images/user-img.png");
    }
?>" class="user-img-big">
    <h3>John Smit</h3>
    <ul>
        <li><a href="<?php echo Yii::app()->createUrl('user/dashboard'); ?>" class="m1 active">Dashboard</a></li>
        <li><a href="#" class="m2">Join Contest</a></li>
        <li><a href="#" class="m3">Create Contest</a></li>
        <li><a href="#" class="m4">Start Contest</a></li>
        <li><a href="#" class="m5">Leader Board</a></li>
        <li><a href="#" class="m6">Prize</a></li>
        <li><a href="#" class="m7">Contact Us</a></li>
        <li><a href="#" class="m8">Tools</a></li>
        <li><a href="#" class="m9">Help</a></li>
        <li><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="m10">Log  Out</a></li>
    </ul>
</div>-->

<!--<div class="col-md-3 col-sm-3 col-xs-12">-->

    <div class="d-pro-box">
        <div class="pro-img">
            <img src="<?php
            $userData = UserMaster::model()->findByPk(Yii::app()->user->id);

            if ($userData->profile_image)
                {
                echo Yii::app()->baseUrl . '/upload/usersImage/' . $userData->profile_image;
                }
            else
                {
                echo Assets::themeUrl("images/img1.png");
                }
            ?>" class=" img-responsive" alt="">
        </div>

<!--        <div class="upload-box"> 

            <div class="input-group comp">
                <span class="input-group-btn">
                    <span class="btn btn-bs4 btn-file">
                        <img src="<?php echo Assets::themeUrl("images/ds-ico1.png"); ?>" class=" img-responsive" alt=""> <input type="file" name="" multiple="">
                    </span>
                </span>
            </div>

            <input type="submit" class="btn btn-dash" value="Post New Job" />

        </div>-->

        <a class="btn btn-ds1 " href="<?php echo Yii::app()->createUrl('bothDashboard/pageSetting'); ?>"><?php echo Yii::t('string', "Page Settings"); ?></a>

        <!--<a class="btn btn-ds1 " href="#">Dispute a service</a>-->

        <a class="btn btn-ds1 " href="<?php echo Yii::app()->createUrl('chat/ManufacturerConversation');?>"><?php echo Yii::t('string', "Send A Messege"); ?></a>
        
        <a class="btn btn-ds1 " href="<?php echo Yii::app()->createUrl('user/purchasedDesigns');?>"><?php echo Yii::t('string', "Bid on Purchased Designs"); ?></a>

        <a class="btn btn-ds1 " href="<?php echo Yii::app()->createUrl('manufacturerDashboard/purchasedCatalog');?>"><?php echo Yii::t('string', "Bid on Purchased Catalogs"); ?></a>
        
        <a class="btn btn-ds1 " href="<?php echo Yii::app()->createUrl('manufacturerDashboard/submittedBids');?>"><?php echo Yii::t('string', "Submitted Bids"); ?></a>
        
        <a class="btn btn-ds1 " href="<?php echo Yii::app()->createUrl('manufacturerDashboard/uploadCatalog');?>"><?php echo Yii::t('string', "Upload Catalog"); ?></a>

    </div><!--dpro-box-->

    <div class="ds-block-box3">
        <h3> <span></span><?php echo Yii::t('string', "Recent Post Blogs"); ?></h3>
        <?php 
    // latest blog 
        $sql = "SELECT bp.post_title as blog_title, bp.post_content as blog_desc, bp.guid as blog_link, bpl.guid as blog_thumbnail, bp.post_date as post_date "
                . "FROM blog_posts as bp LEFT JOIN blog_postmeta as bpm ON bp.ID=bpm.post_id AND meta_key='_thumbnail_id' "
                . "LEFT JOIN blog_posts as bpl ON bpl.ID=bpm.meta_value  "
                . "WHERE bp.post_parent='0' AND bp.post_type='post' ORDER BY bp.post_date DESC limit 3;";
        $connection = Yii::app()->db;   // assuming you have configured a "db" connection
        $command = $connection->createCommand($sql);
        $blogs = $command->queryAll();    // custome query and return all rows of result
    ?>
    <div class="blog-grids">
        <?php foreach($blogs as $blog):?>
        <div class="col-md-12">
            <div class="blog-grid">
                <a href="<?php echo $blog['blog_link'];?>">
                <img alt="" class="img-responsive" src="<?php echo $blog['blog_thumbnail'];?>">
                </a>
                <h4><?php echo $blog['blog_title'];?></h4>
                <p><img src="<?php echo Assets::themeUrl("images/b-ico.png"); ?>" alt=""> <?php echo $blog['post_date'];?></p>
            </div></div>
        <?php endforeach;?>
        


        <div class="col-md-12">
        <!--<a class="show-more" href="#"><i class="fa fa-eye"></i> <span>Show More</span></a>-->
            <a href="<?php echo Yii::app()->baseUrl . '/blog'; ?>" style="padding-left:7px;"><strong><?php echo Yii::t('string', "Show More"); ?></strong></a>        </div>   

        <div class="clearfix"></div>
    </div>
</div><!--ds-block-box3 for bolg-->

<!--</div>col-md-3-->