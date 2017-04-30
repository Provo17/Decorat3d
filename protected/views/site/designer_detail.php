<?php
//$str = "Hello fri3nd, you're
//       looking          good today!";
//print_r(str_word_count($str, 1));
//print_r(str_word_count($str, 2));
//print_r(count(str_word_count($str, 1, 'àáãç3')));
//exit;
//echo "<pre>";
//print_r(Yii::app()->getBaseUrl(true).'/designers-detail/'.$designer->id.'/'.$designer->username.'.html');
//echo "</pre>";
//exit;
?>
<link href="<?php echo Assets::themeUrl("vendor/jraty/lib/jquery.raty.css"); ?>" rel="stylesheet">
<style>
    .reviews span.start img {
        width: 12px;
        height: 12px;
        border: 0px;
        margin-left: 10px;
    }
    .errorMessage{display:none;
                  margin-left: 20%;
                  width: 70%;
    }
</style>
<section class="dash-box">
    <div class="color-box3">
        <div class="container">
            <div class="dash-in"> 
                <h2 class="designerHeading">About Me</h2>
                <div class="designerDetails">
                    <div class="col-md-12 col-sm-12 col-xs-12"><h2><?php echo isset($designer->username) ? $designer->username : ''; ?> </h2></div>
                    <div class="details">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <img src="<?php
                            if ($designer->profile_image)
                                {
                                echo Yii::app()->baseUrl . '/upload/usersImage/' . $designer->profile_image;
                                }
                            else
                                {
                                echo Assets::themeUrl("images/avatarImage.jpg");
                                }
                            ?>">
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12 cvd">
                            <div class="cxvPart"><h3>About <?php echo isset($designer->username) ? $designer->username : ''; ?> </h3>
                            <!--<p>Bettola-Zeloforamagno</p>-->
                                <p>
                                    <?php echo isset($designer->description) ? $designer->description : ''; ?>
                                </p>
                                <!--<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, </p>-->
                                <ul class="list list2">
                                    <li><a href="#">Followers 2</a></li>
                                    <li><a href="#">Following 0</a></li>
                                </ul></div>
                            <div class="area"><h3>Area of Expertise</h3>
                                <div class="skillls detailSkills">
                                    <ul>
                                        <?php
                                        foreach ($designer->userskill as $s_key => $u_skill):
                                            ?>
                                            <li><a href="javascript:void(0);"><?php echo $u_skill->skill->name; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="portfolio">
                        <h3>Portfolios by <?php echo isset($designer->username) ? $designer->username : ''; ?></h3>

                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="carousel_wrap">
                                    <ul>
                                        <?php
                                        if (count($self_uploaded_catalogs))
                                            {
                                            foreach ($self_uploaded_catalogs as $self_uploaded_catalogs_key => $self_uploaded_catalog)
                                                {
                                                if ($self_uploaded_catalog->uploaded_file)
                                                    {
                                                    if ($this->getFileExtention($self_uploaded_catalog->uploaded_file) == 'stl')
                                                        {
                                                        $org_file_name = explode(".", $self_uploaded_catalog->uploaded_file);
                                                        $uploaded_file1 = Yii::app()->request->getBaseUrl(true) . "/upload/catalog/thumb/" . $org_file_name[0] . '.jpg';
                                                        }
                                                    else
                                                        {
                                                        $uploaded_file1 = Yii::app()->baseUrl . '/upload/catalog/thumb/' . $self_uploaded_catalog->uploaded_file;
                                                        }
                                                    ?>
                                                    <li><img src="<?php echo $uploaded_file1; ?>" alt=""></li>                                                    
                                                    <?php
                                                    }
                                                }
                                            }
                                        if (count($designer->jobBid))
                                            {
                                            foreach ($designer->jobBid as $bid_key => $job_bids)
                                                {
                                                $transacrionData = TransactionReport::model()->findByAttributes(['bid_type' => '1', 'bid_id' => $job_bids->id, 'status' => '23']);
                                                if ($transacrionData)
                                                    {
                                                    if ($this->getFileExtention($self_uploaded_catalog->uploaded_file) == 'stl')
                                                        {
                                                        $org_file_name = explode(".", $self_uploaded_catalog->uploaded_file);
                                                        $uploaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/catalog/thumb/" . $org_file_name[0] . '.jpg';
                                                        }
                                                    else
                                                        {
                                                        $uploaded_file = Yii::app()->baseUrl . '/upload/jobs/thumb/' . $transacrionData->bid->uploaded_file;
                                                        }
                                                    ?>
                                                    <li><img src="<?php echo $uploaded_file; ?>" alt=""></li>                                                    
                                                    <?php
                                                    }
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <span class="btn jcarousel-prev" data-scroll="1"></span>
                            <span class="btn jcarousel-next" data-scroll="1"></span>
                        </div>
                    </div>
                    <div class="reviewPartw">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="addR" >
                                    <?php
                                    if (Yii::app()->user->isGuest)
                                        {
                                        ?>
                                        <a href="<?php echo Yii::app()->createUrl('site/login', ['return_url' => Yii::app()->getBaseUrl(true) . '/designers-detail/' . $designer->id . '/' . $designer->username . '.html']); ?>" class="addReview"><i class="glyphicon glyphicon-pencil pencilPlus"></i>Write a review</a>
                                        <?php
                                        }
                                    else
                                        {
                                        if ($is_purchased_design == 'true')
                                            {
                                            ?>
                                            <button type="button" class="addReview" id="vn-click"><i class="glyphicon glyphicon-pencil pencilPlus"></i>Write a review</button>								

                                            <?php
                                            }
                                        else
                                            {
                                            ?>
                                            <button type="button" id="dont_access_to_write" class="addReview"><i class="glyphicon glyphicon-pencil pencilPlus"></i>Write a review</button>								
                                            <?php
                                            }
                                        }
                                    ?>
                                    <br/>
                                    <div id="showWriteError" class="alert-danger" style="text-align: center;padding: 5px 0;margin: 10px 0 0 0; display: none;" >
                                        Sorry! You have not purchased any of <?php echo $designer->username; ?>'s designs.
                                    </div>
                                    <div id="vn-info">
                                        <div class="form-group">
                                            <?php
                                            if (!Yii::app()->user->isGuest)
                                                {
                                                ?>
                                                <?php
                                                $form = $this->beginWidget('CActiveForm', array(
                                                    'id' => 'review-Form',
                                                    'enableClientValidation' => true,
                                                    'clientOptions' => array(
                                                        'validateOnSubmit' => true,
                                                    ),
                                                    'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                                                ));
                                                ?> 
                                                <div class="formPart">
                                                    <input type="hidden" name="to_user" value="<?php echo $designer->id; ?>">
                                                    <label>Projects :</label>
                                                    <?php echo $form->dropDownList($model, 'job_bid_id', $available_jobs, array('class' => 'selectbBox', 'prompt' => "----- Select Project Which  $designer->username Designed -----")); ?>
                                                    <div id="job_bid_id_Err" class="errorMessage"></div>
                                                </div>
                                                <div class="formPart">
                                                    <label>Your Message:</label>
                                                    <?php echo $form->textArea($model, 'review', array('class' => 'textarea', 'placeholder' => 'Write your review here.')); ?>
                                                    <div id="review_Err" class="errorMessage"></div>
                                                </div>
                                                <div class="formPart">
                                                    <label>Rating:</label>
                                                    <span class="start form-rating" ></span>
                                                    <!--<div id="review_Err" class="errorMessage"></div>-->
                                                </div>

                                                <div class="formPart" style="position:relative;">
                                                    <label></label>
                                                    <button type="button" id="review-submit-btn" class="subButton">Submit</button>
                                                    <img style="display:none;height: 50px;width: 50px;position:absolute; left:200px; top:-6px; border:0px; box-shadow:0px 0 0 0;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                                                </div>
                                                <?php $this->endWidget(); ?>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reviews">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 colx-s-12">
                                <h3>Recent reviews</h3>
                            </div>
                        </div>
                        <?php
                        if (isset($current_designer_review) && $current_designer_review)
                            {
                            foreach ($current_designer_review as $key => $review)
                                {
                                ?>
                                <div class="reviewText">
                                    <div class="row">
                                        <div class="col-md-1 col-sm-2 col-xs-12">
                                            <div><img src="<?php echo $review->job_bid->job->job_owner->profile_image != '' ? Yii::app()->getBaseUrl(true) . '/upload/usersImage/thumb/' . $review->job_bid->job->job_owner->profile_image : Assets::themeUrl("images/reviewImage.jpg"); ?>"></div>
                                        </div>
                                        <div class="col-md-11 col-sm-10 col-xs-12">
                                            <h2><a href="#"><?php echo $review->job_bid->job->description; ?></a></h2>
                                            <p><span>5.0</span>
                                                <!--<span class="start rating"><img src="<?php // echo Assets::themeUrl("images/s.png");                        ?>"></span>-->
                                                <span class="start rating" data-rating="<?php echo $review->rating; ?>"></span>
                                                <span class="price">$<?php echo sprintf("%.2f", $review->job_bid->price); ?> USD</span></p>
                                            <p>"<?php echo $review->review; ?>"</p> 
                                            <p class="name">-<span><?php echo $review->job_bid->job->job_owner->username; ?></span><span>at <?php echo date('d/m/Y', strtotime($review->created_at)); ?></span></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                            }
                        ?>                        
                    </div>
                </div>
                <!--col-md-9-->
                <!--<div class="container">
                
                    <ul class="pagination">
                
                        <li><a href="#">&laquo;</a></li>
                
                        <li><a href="#">1</a></li>
                
                        <li><a href="#">2</a></li>
                
                        <li><a href="#">3</a></li>
                
                        <li><a href="#">4</a></li>
                
                        <li><a href="#">5</a></li>
                
                        <li><a href="#">&raquo;</a></li>
                
                    </ul>
                
                
                </div>-->
                <div class="clearfix"></div>
            </div> <!--dash-in-->
        </div><!--/.container-->
    </div><!--color-box3-->
</section>

<script type="text/javascript" src="<?php echo Assets::themeUrl("vendor/jraty/lib/jquery.raty.js"); ?>"></script>
<script type="text/javascript">
    $('.form-rating').raty({
        readOnly: false,
        scoreName: 'Review[rating]',
//        score: function() {
//            return $(this).data('rating');
//        },
        space: true,
        starHalf: "<?php echo Assets::themeUrl("vendor/jraty/lib/images/star-half.png"); ?>", // The name of the half star image.
        starOff: "<?php echo Assets::themeUrl("vendor/jraty/lib/images/star-off.png"); ?>", // Name of the star image off.
        starOn: "<?php echo Assets::themeUrl("vendor/jraty/lib/images/star-on.png"); ?>"
    });
    $('.rating').raty({
        readOnly: true,
        score: function() {
            return $(this).data('rating');
        },
        space: false,
        starHalf: "<?php echo Assets::themeUrl("vendor/jraty/lib/images/star-half.png"); ?>", // The name of the half star image.
        starOff: "<?php echo Assets::themeUrl("vendor/jraty/lib/images/star-off.png"); ?>", // Name of the star image off.
        starOn: "<?php echo Assets::themeUrl("vendor/jraty/lib/images/star-on.png"); ?>"
    });
    $(document).ready(function() {
        $("#vn-click").click(function() {
            $("#vn-info").slideToggle(1000);
        });
    });</script>
<script src="<?php echo Assets::themeUrl('js/jquery.jcarousel.min.js'); ?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.carousel_wrap').jcarousel();
        $('.jcarousel-prev').each(function(p) {
            $(this).on('active.jcarouselcontrol', function() {
                $(this).removeClass('disabled'); //если ещё есть куда проматывать - удаляем касс disabled
            })
                    .on('inactive.jcarouselcontrol', function() {
                        $(this).addClass('disabled'); //если перематывать дальше не куда - добавляем касс disabled
                    })
                    .jcarouselControl({target: '-=' + $(this).data('scroll')}) //крутим на заданное в атрибуте data-scroll="X" количество элементов
        });
        $('.jcarousel-next').each(function(n) {
            $(this).on('active.jcarouselcontrol', function() {
                $(this).removeClass('disabled'); //если ещё есть куда проматывать - удаляем касс disabled
            })
                    .on('inactive.jcarouselcontrol', function() {
                        $(this).addClass('disabled'); //если перематывать дальше не куда - добавляем касс disabled
                    })
                    .jcarouselControl({target: '+=' + $(this).data('scroll')}) //крутим на заданное в атрибуте data-scroll="X" количество элементов
        });
    });
    $('#dont_access_to_write').on('click', function(e) {
        e.preventDefault();
        $('#showWriteError').show();
    });
    jQuery(document).on('click', '#review-submit-btn', function(e) {
        e.preventDefault();
        var _this = $(this);
        $('#review-submit-btn').hide();
        $('.errorMessage').hide();
        $('#job_bid_id_Err').html('');
        $('#review_Err').html('');
        $('.loader').show();
        jQuery.ajax({
            type: 'POST',
            cache: false,
            data: $('#review-Form').serialize(),
            dataType: "json",
            url: "<?php echo Yii::app()->createUrl('site/addReview'); ?>",
            success: function(resp) {
                $('.loader').hide();
                $('#review-submit-btn').show();
                if (resp['type'] == 'success') {
                    window.location.href = '';
                } else {
                    if (typeof (resp.msg.job_bid_id) !== 'undefined') {
                        $('#job_bid_id_Err').html(resp.msg.job_bid_id);
                        $('#job_bid_id_Err').closest('.errorMessage').show();
                    }
                    if (typeof (resp.msg.review) !== 'undefined') {
                        $('#review_Err').html(resp.msg.review);
                        $('#review_Err').closest('.errorMessage').show();
                    }
                }
            }
        });
        return false;
    });
</script>