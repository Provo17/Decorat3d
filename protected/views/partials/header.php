

<header class="navbar navbar-inverse navbar-fixed-top top-bg" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="<?php echo Yii::app()->createUrl('site/index'); ?>"><img src="<?php echo Assets::themeUrl("images/logo.png"); ?>" alt="logo"></a>
      <div class="soc-box hidden-md hidden-lg hidden-sm">
        <?php
                if (Yii::app()->user->isGuest)
                    {
                    ?>
        <a href="<?php echo Yii::app()->createUrl('login'); ?>" class="btn btn-login" >Log In</a>
        <?php
                    }
                else
                    {
                    ?>
        <a href="<?php echo Yii::app()->createUrl('user/logout'); ?>" class="btn btn-login" >Logout</a>
        <?php } ?>
        <a href="#"><img src="<?php echo Assets::themeUrl("images/sc-ico.png"); ?>" alt=""></a> </div>
    </div>
    <div class="collapse navbar-collapse">
      <?php
            if (!Yii::app()->user->isGuest)
                {
                $dashboard = '';
                $userData = UserMaster::model()->findByPk(Yii::app()->user->id);
                if ($userData && $userData->user_type_id == 2)
                    {
                    $dashboard = Yii::app()->createUrl('user/bothDashboard');
                    }
                else
                    {
                    $dashboard = Yii::app()->createUrl('user/manufactureDashboard');
                    }
                }
            ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php
                    if (!Yii::app()->user->isGuest)
                        {
                        echo $dashboard;
                        }
                    else
                        {
                        echo Yii::app()->createUrl('site/index');
                        }
                    ?>"> Home</a></li>
        <li><a href="<?php echo Yii::app()->createUrl('designers'); ?>">Designers </a></li>
        <li><a href="<?php echo Yii::app()->createUrl('gallery'); ?>">Gallery </a></li>
        <li><a href="<?php echo Yii::app()->createUrl('site/manufacturer'); ?>">Manufacturers </a></li>
        <li><a href="<?php echo Yii::app()->baseUrl . '/blog'; ?>">Blog</a></li>
        <li><a href="<?php echo Yii::app()->createUrl('contact-us'); ?>">Contact Us</a></li>
        <li class="hidden-xs logoutClass">
          <?php
                    if (Yii::app()->user->isGuest)
                        {
                        ?>
          <div id="log_menu" class="soc-box"><a href="<?php echo Yii::app()->createUrl('login'); ?>" class="btn btn-login" >Log In</a> </div>
          <?php
                        }
                    else
                        {
                        ?>
          <!--<div class="soc-box"><a href="<?php //echo Yii::app()->createUrl('user/logout');            ?>" class="btn btn-login" ><i class="icon-key"></i>Logout</a> </div>-->
          <div id="profile_menu">
            <div class="userName1"><img src="<?php
                                $userData = UserMaster::model()->findByPk(Yii::app()->user->id);

                                if ($userData->profile_image)
                                    {
                                    echo Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $userData->profile_image;
                                    }
                                else
                                    {
                                    echo Assets::themeUrl("images/avatarImage.jpg");
                                    }
                                    ?>" width="40px" height="40px;" alt="user_logo"> <?php echo $userData->username; ?>
                                    	<div class="dropdown plusDrop">
              <!-- Dropdown Button -->
              <button id="dLabel" role="button" href="#"
                                        data-toggle="dropdown" data-target="#" 
                                        class="btn btn-primary topButton"> <span class="caret"></span> </button>
              <!-- Dropdown Menu -->
              <ul class="dropdown-menu" role="menu" 
                                    aria-labelledby="dLabel">
                <li> <a href="<?php echo $dashboard; ?>">Dashboard</a> </li>
                <?php if ($userData && $userData->user_type_id == 2): ?>
                <li><a href="<?php echo Yii::app()->createUrl('/post-project'); ?>">Post a job</a></li>
                <?php endif; ?>
                <li><a href="<?php echo Yii::app()->createUrl('user/logout'); ?>">Logout</a></li>
              </ul>
          </div>
                                    </div>
            
          <?php } ?>
        </li>
        <li class="hidden-xs hiddenPart">
          <!--<a href="<?php // echo Yii::app()->createUrl('/all-projects'); ?>" ><i class="fa fa-search fa-lg"></i></a>-->
          <a href="<?php echo Yii::app()->createUrl('/search'); ?>" ><i class="fa fa-search fa-lg"></i></a>
          <!--<a href="#" id="searchtoggl"><i class="fa fa-search fa-lg"></i></a>-->
        </li></div>
      </ul>
    </div>
    <!--        <div id="searchbar" class="clearfix">
                    <form id="searchform" method="get" action="searchpage.php">
                        <button type="submit" id="searchsubmit" class="fa fa-search fa-2x"></button>
                        <input type="search" name="s" id="s" placeholder="Search..." autocomplete="off">
                    </form>
                </div>-->
  </div>
  <script>
        $('.dropdown.keep-open').on({
            "shown.bs.dropdown": function() {
                this.closable = false;
            },
            "click": function() {
                this.closable = true;
            },
            "hide.bs.dropdown": function() {
                return this.closable;
            }
        });
    </script>
  <script>
        $(function() {
            var $searchlink = $('#searchtoggl i');
            var $searchbar = $('#searchbar');

            $('#searchtoggl').on('click', function(e) {
                e.preventDefault();

                if ($(this).attr('id') == 'searchtoggl') {
                    if (!$searchbar.is(":visible")) {
                        // if invisible we switch the icon to appear collapsable
                        $searchlink.removeClass('fa-search').addClass('fa-search-minus');
                    } else {
                        // if visible we switch the icon to appear as a toggle
                        $searchlink.removeClass('fa-search-minus').addClass('fa-search');
                    }

                    $searchbar.slideToggle(300, function() {
                        // callback after search bar animation
                    });
                }
            });

            $('#searchform').submit(function(e) {
                // stop form submission
            });
        });</script>
</header>
<!--/header-->
