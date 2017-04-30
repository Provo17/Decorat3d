<section class="dash-box">
    <div class="color-box3">
        <div class="container">
            <div class="dash-in">
                <h2>Check Out</h2>
                <?php if (Yii::app()->user->hasFlash('error')): ?>
                    <br/>
                    <div role="alert" class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Yii::app()->user->getFlash('error'); ?>
                    </div>
                <?php endif; ?> 
                <div class="checkOutPart">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="creditDetails">
                                <h3>Enter Credit Card Details</h3>
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'review-Form',
                                    'enableClientValidation' => FALSE,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                    ),
                                    'htmlOptions' => ['class' => '', 'role' >= 'form', 'enctype' => 'multipart/form-data'],
                                ));
                                ?> 
                                <div class="card">
                                    <div class="cardName">Name On Card</div>
                                    <div class="cardField">
                                        <?php echo $form->textField($creditModel, 'card_holder_name', array('class' => 'textField2')); ?>
                                        <?php echo $form->error($creditModel, 'card_holder_name'); ?>
                                        <!--<input type="text" class="textField2">-->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="card">
                                    <div class="cardName">Credit Card Type</div>
                                    <div class="cardField">
                                        <?php
                                        $type = array('Visa' => 'Visa', 'MasterCard' => 'Master Card', 'Discover' => 'Discover', 'Amex' => 'American Express');
                                        echo $form->dropDownList($creditModel, 'credit_card_type', $type, array('class' => 'form-control selectPart', 'prompt' => "Please Select"));
                                        ?>
                                        <?php echo $form->error($creditModel, 'credit_card_type'); ?>
<!--                                        <select id="basic" class="form-control selectPart">
                                            <option value="-">Please select</option>
                                            <option class="size1" >Mastro</option>
                                            <option class="size2" >Visa</option>
                                        </select>-->
                                    </div>
                                    <div class="card1"><img src="<?php echo Assets::themeUrl("images/masterCard.png"); ?>"></div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="card">
                                    <div class="cardName">Credit Card Number</div>
                                    <div class="cardField">
                                        <?php echo $form->textField($creditModel, 'card_number', array('class' => 'textField2', 'maxlength' => '19')); ?>
                                        <?php echo $form->error($creditModel, 'card_number'); ?>
                                        <!--<input type="text" class="textField2">-->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="card">
                                    <style>
                                        .yearErr{border:solid 1px #fdadad;background-color: #ffe4e4;}
                                    </style>
                                    <div class="cardName">Expiration Date</div>
                                    <div class="cardField">     
                                        <?php
                                        $yearErr = $monthErr = '';
                                        $creditModel->hasErrors('expiry_month') != NULL ? $monthErr = "yearErr" : '';
                                        $creditModel->hasErrors('expiry_year') != NULL ? $yearErr = "yearErr" : '';
                                        ?>
                                        <?php echo $form->textField($creditModel, 'expiry_month', array('class' => "textField23 $monthErr", "placeholder" => "MM", 'maxlength' => '2')); ?>
                                        <?php echo $form->textField($creditModel, 'expiry_year', array('class' => "textField23 $yearErr", 'placeholder' => "YYYY", 'maxlength' => '4')); ?>

<!--                                       <input type="text" class="textField23" placeholder="MM">
                                        <input type="text" class="textField24" placeholder="YYYY"> -->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="card">
                                    <div class="cardName">CVV</div>
                                    <div class="cardField">
                                        <?php echo $form->passwordField($creditModel, 'cvv', array('class' => 'textField24', 'placeholder' => "", 'maxlength' => '4')); ?>
                                        <?php echo $form->error($creditModel, 'cvv'); ?>
                                        <!--<input type="text" class="textField24">--> 
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="creditDetails">
                                <div class="checkbox">
                                    <label><?php echo $form->checkBox($creditModel, 'tc', array('class' => '')); ?><a data-toggle="modal" href="#large" >I understand and accept the <span>Terms and Condition</span></a></label>
                                    <?php echo $form->error($creditModel, 'tc'); ?>
                                </div>
                                <div class="totalPrice">
                                    <div class="priceleft">Subtotal:</div>
                                    <div class="priceright">$<?php echo sprintf("%.2f", $model->amount); ?></div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="totalPrice">
                                    <div class="priceleft">Total:</div>
                                    <div class="priceright">$<?php echo sprintf("%.2f", $model->amount); ?></div>
                                    <div class="clearfix"></div>
                                </div>
                                <button type="submit" class="buyNow">Buy Now</button>
                                <?php $this->endWidget(); ?>
                                <p class="or">Or</p>
                                <a href="<?php echo Yii::app()->createUrl('/pay-now'); ?>?src=<?php echo $src; ?>" class="buyNow1"><p class="buyNow121">Buy Now with</p> <p><img src="<?php echo Assets::themeUrl("images/paypalLogo.png"); ?>"></p></a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="orderPart">
                    <h2>Your Order</h2>
                    <div class="itemPart">
                        <div class="item1">Design</div>
                        <div class="item2">Price</div>
                        <div class="item3">Subtotal</div>
                    </div>
                    <div class="itemPart1">
                        <div class="itemP1">
                            <div class="image1"><img src="<?php echo Yii::app()->request->getBaseUrl(true) ?>/upload/<?php echo $design_img; ?>"></div>
                            <div class="name"><?php
                                if (strlen($description) >= 18)
                                    {
                                    $pos = strpos($description, ' ', 18);
                                    $descriptions = substr($description, 0, $pos);
                                    $descriptions = $description . '..';
                                    }
                                else
                                    {
                                    $descriptions = $description;
                                    }
                                echo wordwrap($descriptions, 8, "\n", true);
                                ?></div>
                        </div>
                        <div class="itemP2">$<?php echo sprintf("%.2f", $model->amount); ?></div>
                        <div class="itemP2">$<?php echo sprintf("%.2f", $model->amount); ?></div>
                    </div>
                </div>
            </div> <!--dash-in-->
        </div><!--/.container-->
    </div><!--color-box3-->
</section>

<div class="modal fade bs-modal-lg " id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modalPart" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Terms & Policies</h4>
            </div>
            <div class="modal-body">
                <?php
                if (isset($tc))
                    {
                    echo $tc;
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default signButton" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn blue">Save changes</button>-->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
