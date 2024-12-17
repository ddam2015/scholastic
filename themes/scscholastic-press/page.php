<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * @package OGP Press
 * @since OGP 1.0.0
 */
get_header();
$scscholastic_ad_info = scscholastic_start_ads( $post->ID );

?>
<div class="grid-container">
  <section id="content" class="grid-x site-main <?php echo ( (has_post_thumbnail( $post->ID ) || get_post_meta($post->ID, 'hero-video', true)) && !is_product() ) ? 'featured-image small-padding-top ' : ''; ?>xlarge-padding-bottom<?php if ( $scscholastic_ad_info['go'] ) echo $scscholastic_ad_info['ad_section_class']; ?>" role="main">
    <div class="cell small-12">
      <?php
      if ( $scscholastic_ad_info['go'] ) echo $scscholastic_ad_info['ad_before'] . $scscholastic_ad_info['ad_content'] . $scscholastic_ad_info['ad_after'];
      if ( have_posts() ) : 
      if ( is_home() && ! is_front_page() ) : ?>
      <div class="tiny-margin-bottom tiny-padding gset no-border">
        <h1 class="entry-title screen-reader-text"><?php single_post_title(); ?></h1>
      </div>
      <?php endif;

      while ( have_posts() ) : the_post();

        get_template_part( 'page-parts/content', get_post_type() );

      endwhile;
      // If no content, include the "No posts found" template.
      else :

        get_template_part( 'page-parts/content', 'none' );

      endif;
      ?>
    </div>
  </section>
</div>

<?php get_footer(); ?>