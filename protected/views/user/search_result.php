<!--dash box-->
<section class="dash-box">
    <div class="color-box4">
        <div class="heading">
            <h2>See All Projects</h2>
        </div>
        <div class="searchJob">
            <div class="container job1">
                <?php
//                if (isset($all_jobs) && $all_jobs)
//                    {
//                    foreach ($all_jobs as $key => $jobs)
//                        {
                        ?>
                        <div class="row jobPart1">
                            <div class="col-md-1 col-sm-2 col-xs-3">
                                <img src="<?php
//                                if ($jobs->uploaded_file != '')
//                                    {
//                                    $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/upload/jobs/" . $jobs->uploaded_file;
//                                    }
//                                else
//                                    {
                                    $uplpoaded_file = Yii::app()->request->getBaseUrl(true) . "/themes/admin/assets/admin/layout/img/no_image_available.jpg";
//                                    }
                                echo $uplpoaded_file;
                                ?>">
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-6">
                                <div class="contentMiddlePart">
                                    <h2><a href="#"><?php // echo strlen($jobs->description) > 57 ? substr($jobs->description, 0, 57) : $jobs->description; ?>..</a></h2>
                                    <p>By <a href="#"><?php // echo $jobs->job_owner->username; ?></a></p>
                                    <span><?php // echo date_format(date_create($jobs->created_at), 'g:ia \o\n l jS F Y');?></span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-3">
                                <!--<a href="<?php // echo Yii::app()->createUrl('bothDashboard/jobDetails', ['id' => $jobs->id]); ?>" class="applyNow pull-right">Bid Now</a>-->
                            </div>
                        </div>
                        <?php
//                        }
//                    }
                ?>
            </div>
        </div>
    </div>
</section>
<!--/dash box-->
