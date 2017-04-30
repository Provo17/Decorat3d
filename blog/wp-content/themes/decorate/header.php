<?php $main_url = '';
$main_url = str_replace('blog','',site_url());
?>
<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/css/animate.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
        <![endif]-->

        <?php wp_head(); ?>
        <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.prettyPhoto.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>


    </head>

    <body <?php body_class(); ?>>
        <div id="page" class="hfeed site">
            <header class="navbar navbar-inverse navbar-fixed-top top-bg">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                        <a class="navbar-brand" href="<?php echo $main_url;?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"></a>
                        <div class="soc-box hidden-md hidden-lg hidden-sm"><a href="<?php echo $main_url;?>login.html" class="btn btn-login" >Log In</a> <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/sc-ico.png" alt=""></a></div>
                    </div>
                    <div class="collapse navbar-collapse">

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo $main_url;?>">Home</a></li>
                            <li><a href="<?php echo $main_url;?>designers.html">Designers </a></li> 
                            <li><a href="<?php echo $main_url;?>gallery.html">Gallery </a></li>
                            <li><a href="<?php echo $main_url;?>manufacturers">Manufacturers </a></li>
                            <li><a href="<?php echo $main_url;?>blog/">Blog</a></li> 
                            <li><a href="<?php echo $main_url;?>contact-us.html">Contact Us</a></li>
                            <!--            <li class="hidden-xs">
                                          <div class="soc-box"><a href="/apps/decorate3d/public/login.html" class="btn btn-login" >Log In</a> </div>
                                        </li>-->
                            <li class="hidden-xs logoutClass">
                               
                                <div id="log_menu" style="display:none;"class="soc-box"><a href="<?php echo $main_url;?>login.html" class="btn btn-login" >Log In</a> </div>
                                   
                                    <div id="profile_menu" style="display:none;">
                                        <div class="userName1"><img id="profile_img" width="40px" height="40px;" src="<?php echo get_template_directory_uri(); ?>/images/avatarImage.jpg" alt=""> username</div>
                                        <div class="dropdown plusDrop">
                                            <!-- Dropdown Button -->
                                            <button id="dLabel" role="button" href="#"
                                                    data-toggle="dropdown" data-target="#" 
                                                    class="btn btn-primary topButton">
                                                <span class="caret"></span>
                                            </button>

                                            <!-- Dropdown Menu -->
                                            <ul class="dropdown-menu" role="menu" 
                                                aria-labelledby="dLabel">
                                                <li>
                                                    <a id="dashboard_url" href="<?php echo $main_url;?>">Dashboard</a>
                                                </li>
                                                <?php // if ($userData && $userData->user_type_id == 2):  ?>
                                                    <li><a href="<?php echo $main_url.'post-project';?>">Post a job</a></li>
                                                <?php // endif;  ?>
                                                <li><a href="<?php echo $main_url;?>site/logout.html">Logout</a></li>
                                            </ul>
                                        </div>
                                    </div>      
                            </li>
                            <li class="hidden-xs"><a href="<?php echo $main_url;?>search.html"><i class="fa fa-search fa-lg"></i></a></li>
                        </ul>
                    </div>
                </div>
            </header>
            <!--/header-->
            <section class="dash-box">
            
            <script>
                jQuery(document).ready(function(e) {
                    var main_url = "<?php echo $main_url;?>";
                    jQuery.ajax({
                        type: 'POST',
                        cache: false,
                        dataType: "json",
                        url: main_url +'site/ifSetSession',
                        success: function(resp) {
                            if (resp.type == 'success') {
                                jQuery('#profile_menu').show();
                                jQuery('#log_menu').hide();
                                jQuery('#profile_img').attr('src',resp.profile_img);
                                jQuery('#dashboard_url').prop("href", resp.dashboard_url);
                            } else {
                                jQuery('#profile_menu').hide();
                                jQuery('#log_menu').show();
                            }
                        }
                    });
                });
            </script>
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
