<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div class="color-box4">
		<div class="container">
            <div class="row">
                <div class="col-md-9">
                <div class="inner-content">
                <?php /* The loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
    
                    <?php get_template_part( 'content', get_post_format() ); ?>
                    
                    <?php comments_template(); ?>
    
                <?php endwhile; ?>
                </div>
                </div>
                <div class="col-md-3">
                	<div class="ds-block-box3">
                	<?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
		</div><!-- .container -->
	</div><!-- .color-box4 -->


<?php get_footer(); ?>