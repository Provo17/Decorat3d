<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"><?php echo strlen($description) > 57 ? substr($description, 0, 57) : $description; ?>..</h2>
    </div><!--col-md-12-->
</div><!--row-->
<?php
?>
<div class="ds-block-pro">
    <h3> <span></span> Total Bid: <?php echo isset($total_bids) ? $total_bids : '0'; ?> Bids
        <!--<span class="posted_on">3 Days Left</span>-->
    </h3>
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <br/>
        <div role="alert" class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?> 
    <div class="postDetail">
        <div class="postImage"><img src="<?php echo Yii::app()->baseUrl . '/upload/' . $uploaded_file; ?>"/></div>

        <div class="desButton">
            <!--            <a style="margin-bottom: 20px;" class="applyNow pull-right accepted" href="javascript:void(0);">
            <?php // echo $design_accepted; ?>
                        </a>
                        <p class="text-center" style="font-size:20px;font-weight: bold;">$<?php // echo $designData->price;         ?></p>-->
            <?php
            if ($posted_by_id != Yii::app()->user->id):
                if ($userData->user_type_id == 3):
                    ?>
                    <a id="show_bid_form_btn" class="applyNow pull-right accepted" href="javascript:void(0);">Bid on This Design</a>
                    <?php
                endif;
            endif;
            ?>
        </div>   

        <div class="clearfix"></div>
        <h2>Description</h2>
        <div class="postDetailsP"><p>
                <?php echo isset($description) ? $description : '' ?>
            </p>
            By <a href="#"><?php echo $posted_by; ?></a>

        </div>
        <div class="clearfix"></div>
    </div>  
    <div id="bid_form" style="<?php
    if (isset($err) && $err == 'yes') {
        
    } else {
        ?>display: none;<?php } ?>"class="row">
        <div class="feture-grids">
            <div class="col-md-12">
                <div class="feture-grid">
                    <div class="pro-des" style="height:100%; overflow:hidden;">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'bid-form',
                            'htmlOptions' => array('enctype' => 'multipart/form-data'),
                            //'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'enableAjaxValidation' => false,
                        ));
                        ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price: </label>
                            <?php echo $form->textField($model, 'price', array('class' => 'form-control', 'placeholder' => 'Price')); ?>
                            <?php if (isset($price_err) && $price_err != ''): ?>
                                <div class="errorMessage"><?php echo $price_err; ?></div>
                            <?php endif; ?>
                        </div>                        
                        <button type="submit" id="sbid-form_submit_btn" class="btn btn-default buyButton">Submit</button>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>    
        </div>
    </div><!--row-->

</div>
<br/>
<?php
if ($posted_by_id != Yii::app()->user->id):
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="status-box">
                <ul class="nav nav-tabs" role="tablist">
                    <h3 class="pull-left">BIDDING (<?php echo isset($total_bids) ? $total_bids : '0'; ?>)</h3>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="manufacturert-ds">
                        <div class="table-responsive">
                            <table width="100%" border="0" class="table table-striped" style="margin-bottom:0px;">

                                <?php
                                if (isset($manufacturer_bids) && count($manufacturer_bids)) {
                                    ?>
                                    <tr>
                                        <th align="left" valign="top"><strong>Manufacturer</strong></th>
                                        <th align="left" valign="top"><strong>Date</strong></th>
                                        <th align="left" valign="top" width="50"><strong>Price</strong></th>
                                        <th align="left" valign="top" width="70">&nbsp;</th>
                                    </tr>
                                    <?php
                                    foreach ($manufacturer_bids as $b_index => $bid) {
                                        ?>
                                        <tr>
                                            <td align="left" valign="top"><img src="<?php
                                                if ($bid->manufacturer->profile_image != '') {
                                                    echo Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $bid->manufacturer->profile_image;
                                                } else {
                                                    echo Assets::themeUrl("images/avatarImage.jpg");
                                                }
                                                ?>" width="50"> <a href="#" class="view-link"><?php echo count($bid->manufacturer) ? $bid->manufacturer->username : ''; ?></a></td>
                                            <td align="left" valign="top"><?php echo date_format(date_create($bid->created_at), 'jS F Y'); ?></td>
                                            <td align="left" valign="top" width="70">$ <?php echo $bid->price; ?></td>
                                            <td align="left" valign="top" width="120">
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td align="center" valign="top" colspan="4"><strong>No Bidding Yet</strong></td>
                                    </tr>
                                <?php }
                                ?>                               
                            </table>
                        </div>
                    </div> <!--manufacturert-ds-->
                    <!--employer-ds-->
                </div><!-- tab-content-->
            </div>  <!--status-box--> 
        </div><!--col-md-12-->
    </div>
<?php endif; ?>
<script>
//    $( "#show_bid_form_btn" ).toggle();
//    $(document).on('click', '#show_bid_form_btn', function(e) {
//        e.preventDefault();
//        $('#bid_form').show();
//    });
    $("#show_bid_form_btn").click(function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: $(window).height()}, 1000);
        $('#bid_form').show();
    });
</script>