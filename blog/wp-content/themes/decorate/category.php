<?php
/**
 * The template for displaying Category pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
                <?php if ( have_posts() ) : ?>
                    <header class="archive-header">
                        <h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'twentythirteen' ), single_cat_title( '', false ) ); ?></h1>
        
                        <?php if ( category_description() ) : // Show an optional category description ?>
                        <div class="archive-meta"><?php echo category_description(); ?></div>
                        <?php endif; ?>
                    </header><!-- .archive-header -->
        
                    <?php /* The loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'content', get_post_format() ); ?>
                    <?php endwhile; ?>
        
                    <?php twentythirteen_paging_nav(); ?>
        
                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
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