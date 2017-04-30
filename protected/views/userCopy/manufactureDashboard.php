<div class="row">
    <div class="col-md-12">
        <h2 class="top-title"> Manufacturer</h2>
    </div><!--col-md-12-->
</div><!--row-->
<div class="row">
    <div class="col-md-12">
        <div class="ds-block-pro">
            <h3> <span></span> Print Design</h3>
            <div class="row">
                <div class="feture-grids">
                    <?php
                    if (isset($manufacturerBids) && $manufacturerBids!=NULL) {
                        foreach ($manufacturerBids as $manufacturerBid) {
                            ?>                            
                            <div class="col-md-6 child-listing">
                                <div class="feture-grid">
                                    <img alt="" class="img-responsive" src="<?php echo $manufacturerBid['image']; ?>">
                                    <div class="pro-des">
                                        <div class="price-tag">$<?php echo $manufacturerBid['amount']; ?></div>
                                        <p><?php echo strlen($manufacturerBid['description']) > 57 ? substr($manufacturerBid['description'], 0, 57) : $manufacturerBid['description']; ?>...</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    
                    ?>

                    <div class="clearfix"></div>
                </div> <!-- feture-grids-->
                <div align="center">
                    <a class="btn btn-bs1" href="#" onClick='loadMoreManufacture()' id='loadMoreManufactureButton'>Load More...</a>
                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                    <span id="centerDiv" style="display:none;"></span>
                </div>
                
                <input type='hidden' value='<?php echo $offset;?>' name='offset' id='offset'>
                <input type='hidden' value='<?php echo $limit;?>' name='limit' id='limit'>

            </div><!--/row-->
        </div> <!--/ds-block-pro-->

    </div><!--col-md-12-->
</div><!--row-->

<div class="row">
    <div class="col-md-12">
        <div class="status-box">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <h3 class="pull-left"> Status</h3>
                <li role="presentation" class="active"><a href="#manufacturert-ds" aria-controls="manufacturert-ds" role="tab" data-toggle="tab">Manufacturer</a></li>
                <li role="presentation" ><a href="#employer-ds" aria-controls="employer-ds" role="tab" data-toggle="tab">Employer</a></li>

            </ul>
            <!-- Nav tabs end -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="manufacturert-ds">

                    <table width="100%" border="0" class="table table-bordered">
                        <tr>
                            <td align="center">Monthly / yearly  Revenue</td>
                            <td align="center">Work in Progress</td>
                            <td align="center">Hired Manufacturer</td>
                        </tr>
                        <tr>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>10</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Past 30 Days</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">Yearly</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>$0.000</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>$1000.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">1 active project</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">1 active milestone</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Lifetime</td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                </div> <!--manufacturert-ds-->


                <div role="tabpanel" class="tab-pane " id="employer-ds">

                    <table width="100%" border="0" class="table table-bordered">
                        <tr>
                            <td align="center">Monthly / yearly  Revenue</td>
                            <td align="center">Work in Progress</td>
                            <td align="center">Hired Manufacturer</td>
                        </tr>
                        <tr>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>300</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>10</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Past 30 Days</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">Yearly</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>$0.000</strong></td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top"><strong>$5000.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">1 active project</td>
                                        <td align="center" valign="top">&nbsp;</td>
                                        <td align="center" valign="top">1 active milestone</td>
                                    </tr>
                                </table></td>
                            <td><table width="100%" border="0">
                                    <tr>
                                        <td align="center" valign="top"><strong>5</strong></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">Lifetime</td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>

                </div><!--employer-ds-->
            </div><!-- tab-content-->

        </div>  <!--status-box--> 

    </div><!--col-md-12-->
</div><!--row-->

<script>
    $(document).ready(function(){
        
    });
    
    function loadMoreManufacture(){
        var offset=$("#offset").val();
        var limit=$("#limit").val();        
        
        $("#loadMoreManufactureButton").hide('slow', function(){
            $(".loader").show('slow');
        });
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl('userCopy/manufactureDashboardLoadMore');?>",
            type: "GET",
            dataType: "json",
            data: {offset: offset+limit, limit: 6},
            success: function(result){
                var insertPos=$('.feture-grids .child-listing:last');
                if(result.status=='error'){
                    insertPos.after(result.msg).css({color:red});
                    $(".loader").hide('slow');
                }else if(result.status=='noMore'){
                    $(".loader").hide('slow', function(){
                        $("#centerDiv").append(result.msg).css('color',"red").css('font-weight', "bold").show('slow');
                    });
                }else{
                    $.each(result.manufacturerBids, function(){
                        var html='<div class="col-md-6 child-listing">'
                                    +'<div class="feture-grid">'
                                        +'<img alt="" class="img-responsive" src="'+this.image+'">'
                                        +'<div class="pro-des">'
                                            +'<div class="price-tag">$'+this.amount+'</div>'
                                            +'<p>'+this.description+'</p>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>';
                        insertPos.after(html);
                    });
                    $("#offset").val(result.offset);
                    $("#limit").val(result.limit);
                    $(".loader").hide('slow', function(){
                        $("#loadMoreManufactureButton").show('slow');
                    });                    
                }                             
            }
        });
    }
</script>
