<!--dash box-->
<section class="dash-box">
    <div class="color-box3">
        <div class="container">
            <div class="dash-in"> 
                <h2 class="designerHeading">Meet Our Manufacturers</h2>
                <div class="manufacturer-list">
                    <?php
                    if ($manufacturers) {
                        foreach ($manufacturers as $d_index => $manufacturer) {
                            ?>
                            <div class="designerGroup">
                                <div class="col-md-2 col-sm-3 col-xs-12">
                                    <a href="<?php echo Yii::app()->createUrl('manufacturer-detail/' . $manufacturer->id . '/' . str_replace(' ', '-', isset($manufacturer->username) ? $manufacturer->username : '')); ?>">
                                        <div class="deMan image-hover img-zoom-in"><img src="<?php
                                            if ($manufacturer->profile_image) {
                                                echo Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $manufacturer->profile_image;
                                            } else {
                                                echo Assets::themeUrl("images/avatarImage.jpg");
                                            }
                                            ?>">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <div class="nameDesigner">
                                        <h2>
                                            <a href="<?php echo Yii::app()->createUrl('manufacturer-detail/' . $manufacturer->id . '/' . str_replace(' ', '-', isset($manufacturer->username) ? $manufacturer->username : '')); ?>">
                                                <?php echo isset($manufacturer->username) ? $manufacturer->username : ''; ?>
                                            </a>
                                        </h2>
            <!--                                    <p>Bettola-Zeloforamagno</p>-->
                                        <p>
                                            <?php
                                            if (strlen($manufacturer->description) > 214) {
                                                $pos = strpos($manufacturer->description, ' ', 200);
                                                $abouData = substr($manufacturer->description, 0, $pos);
                                            } else {
                                                $abouData = $manufacturer->description;
                                            }
                                            echo wordwrap($abouData, 8, "\n", true);
                                            ?>
                                        </p>
                                        <ul class="list">
                                            <li><a href="#">Followers 2</a></li>
                                            <li><a href="#">Following 0</a></li>
                                        </ul>
                                    </div>
                                    <?php
                                    $no_of_skills = 0;
                                    if (count($manufacturer->userskill) > 0):
                                        ?>
                                        <div class="skillls">
                                            <ul>
                                                <?php
                                                $no_of_skills = count($manufacturer->userskill);
                                                foreach ($manufacturer->userskill as $s_key => $u_skill):
                                                    if ($s_key + 1 > 2) {
                                                        break;
                                                    }
                                                    ?>
                                                    <li><a href="javascript:void(0);"><?php echo $u_skill->skill->name; ?></a></li>
                                                    <?php
                                                endforeach;
                                                if ($no_of_skills > 2):
                                                    ?>
                                                    <li><a href="<?php echo Yii::app()->createUrl('manufacturer/' . $manufacturer->id . '/' . str_replace(' ', '-', isset($manufacturer->username) ? $manufacturer->username : '')); ?>">More</a></li>
                                                    <?php
                                                endif;
                                                ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>                                
                                </div>
                            </div>
                            <?php
                        }
                    }else {
                        ?>
                        <div class="designerGroup">
                            <div class="col-md-12">
                                <center><p style="color:red;">Oops! No Manufacturer Found</p></center>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div align="center" id="centralErrorDiv">
                    <input type="hidden" name="key" id="key">
                    <input type="hidden" name="offset" id="offset">
                    <input type="hidden" name="limit" id="limit">
                    <img style="display:none;height: 35px;width: 35px;" class="loader img-responsive" src="<?php echo Assets::themeUrl("images/processing.gif"); ?>" />
                </div>
                <div class="clearfix"></div>
            </div> <!--dash-in-->
        </div><!--/.container-->
    </div><!--color-box3-->
</section>
<!--/dash box-->

<script>
    $(document).ready(function() {
        $('#key').val(<?php echo $key; ?>);
        $('#offset').val(<?php echo $offset; ?>);
        $('#limit').val(<?php echo $limit; ?>);

        if ($(window).height() == $(document).height()) {
            loadMore($('#key').val(), $('#offset').val(), $('#limit').val());
        }
    });

    $(document).scroll(function() {
        if ($('#limit').val() == 0) {
            return;
        }
        if ($(window).height() + $(window).scrollTop() == $(document).height()) {
            loadMore($('#key').val(), $('#offset').val(), $('#limit').val());
        }
    });

    function loadMore(key, offset, limit) {
        console.log(offset + ', ' + limit);
        $(".loader").show('slow');
        $.ajax({
            async: false,
            url: "<?php echo Yii::app()->createAbsoluteUrl('site/loadMoreManufacturer'); ?>",
            type: "GET",
            dataType: "json",
            data: {key: key, offset: parseInt(offset) + parseInt(limit), limit: limit},
            success: function(result) {
                if (result.status == 'error') {
                    $("#centralErrorDiv").append('<div>' + result.msg + '</div>').css({color: red});
                    $(".loader").hide('slow');
                } else if (result.status == 'noMore') {
                    $(".loader").hide('slow', function() {
                        $("#centralErrorDiv").append('<div style="margin-top:25px;">' + result.msg + '</div>').css('color', "red").css('font-weight', "bold").show('slow');
                    });
                } else {
                    $.each(result.msg, function(index, item) {
                        var html = '<div class="designerGroup">'
                                + '<div class="col-md-2 col-sm-3 col-xs-12">'
                                + '<a href="' + item.link + '">'
                                + '<div class="deMan image-hover img-zoom-in"><img src="' + item.image + '">'
                                + '</div>'
                                + '</a>'
                                + '</div>'
                                + '<div class="col-md-10 col-sm-9 col-xs-12">'
                                + '<div class="nameDesigner">'
                                + '<h2>'
                                + '<a href="' + item.link + '">'
                                + item.username
                                + '</a>'
                                + '</h2>'
                                + '<p>'
                                + item.description
                                + '</p>'
                                + '<ul class="list">'
                                + '<li><a href="#">Followers 2</a></li>'
                                + '<li><a href="#">Following 0</a></li>'
                                + '</ul>'
                                + '</div>';
                        if (item.skillCount > 0) {
                            html += '<div class="skillls"><ul>';
                            $.each(item.skillName, function() {
                                html += '<li><a href="javascript:void(0);">' + this + '</a></li>';
                            });
                            if (item.skillCount > 2) {
                                html += '<li><a href="' + item.link + '">More</a></li>';
                            }
                            html += '</ul></div>';
                        }
                        html += "</div></div>";
                        $('.manufacturer-list').append(html);
                    });
                    $(".loader").hide('slow');
                }
                $('#offset').val(result.offset);
                $('#limit').val(result.limit);
            }
        });
    }
</script>