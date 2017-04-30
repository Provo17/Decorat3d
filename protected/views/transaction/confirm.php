<!--dash box-->
<section class="page-section1 section2"> 
    <div class="container"> 
        <div class="dash-in"> 
            
            <div class="row"><div class="container padding-left"><div class="col-md-3 col-sm-8">
                <img src="<?php echo Assets::themeUrl("images/success.png"); ?>" alt=""/>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12">
            	<h2>Design purchased succesfully.</h2>
                <p>Thank you for purchasing a design.</p>
                <!--<p>You will receive a confirmation email shortly.</p>-->
                <a href="<?php echo Yii::app()->createUrl('user/bothDashboard');?>" class="btn btn-default regButton1">Dashboard</a>
            </div></div></div>
            <!--col-md-9-->  
            <div class="clearfix"></div>
        </div>  
    </div>      
    <!--/.container-->
</section>
<!--/dash box-->
