<?php
/**
 * The front page template
 * @package OGP  Press
 * @since OGP 1.0.0
 */

// News query for the slider
$news_feat = new WP_Query( array( 'category_name' => 'Featured', 'posts_per_page' => 6 ) );

//https://dev.grassroots365.com/wp-content/uploads/display-assets/event-promo-scscholastic.jpg
//https://dev.grassroots365.com/wp-content/uploads/2017/11/scscholastic-posts-banner.jpg
get_header();
// $product_event = g365_conn( 'g365_get_event_data', [$product_event_link, true] ); print_r($product_event);
//see if we need a splash display
$scscholastic_ad_info = scscholastic_start_ads( $post->ID );

$default_img = get_site_url() . '/wp-content/themes/scscholastic-press/scscholastic_default_placeholder.gif';
$bigBG = 'https://scholasticseries.com/' . '/wp-content/uploads/2023/01/Scholastic-Banner-Blank.jpg';

$smallBG = 'https://scholasticseries.com/' . '/wp-content/uploads/2023/01/Scholastic-Banner-Blank.jpg';

$scscholastic_layout_type = get_option( 'scscholastic_layout' );
if( $scscholastic_layout_type['front_layout']['type'] === 'tiles' && count($news_feat->posts) === 6 ){
  //trigger for tile video support
  $tile_vid = false;
  $tile_video_settings = [];

  //get tile banner
	$scscholastic_tile_banner = get_option( 'scscholastic_display' );
	//reassign to focus on tile banner
	$scscholastic_tile_banner = $scscholastic_tile_banner['site_4'];
  $scscholastic_tile_banner_build = '';
  //build tile banner from global settings if we have data
  if ( !empty($scscholastic_tile_banner['title']) ) {
    if ( !empty($scscholastic_tile_banner['link']) ) {
      $scscholastic_tile_banner_build .= '<h2 class="no-margin"><a href="' . $scscholastic_tile_banner['link'] . '">' . $scscholastic_tile_banner['title'] . '</a></h2>';
    } else {
      $scscholastic_tile_banner_build .= '<h2 class="no-margin">' . $scscholastic_tile_banner['title'] . '</h2>';
    }
  }
  if ( !empty($scscholastic_tile_banner['sub_title']) ) $scscholastic_tile_banner_build .= '<p class="no-margin">' . $scscholastic_tile_banner['sub_title'] . '</p>';
  function scscholastic_tile_template( $target_num, $news_feat, $classes ) {
    $tile_type = get_post_meta($news_feat->posts[$target_num]->ID, 'video_head', true);
    if( empty($tile_type) ) {
      $tile_type = '<img src="' . (( has_post_thumbnail($news_feat->posts[$target_num]->ID) ) ? get_the_post_thumbnail_url( $news_feat->posts[$target_num]->ID, "featured-tile" ) : get_site_url() . "/wp-content/themes/scscholastic-press/assets/scscholastic_profile_placeholder_640x640.jpg") . '" alt="' . $news_feat->posts[$target_num]->post_title . '" />';
    } else {
      $video_settings = explode(":", $tile_type);
      if( $video_settings[0] === 'youtube' ) {
        global $tile_vid;
        global $tile_video_settings;
        $tile_type = '<div id="tile_player_' . $news_feat->posts[$target_num]->ID . '"></div>';
        $tile_vid = true;
        $tile_video_settings[] = (object) [
          'id' => 'tile_player_' . $news_feat->posts[$target_num]->ID,
          'data'=> (object)[
            'height' => '640.125',
            'width' => '1138',
            'videoId' => $video_settings[1],
            'playerVars' => (object)[
              'controls' => 0,
              'fs'  => 0,
              'modestbranding'  => 1,
              'enablejsapi' => 1,
              'loop' => 1,
              'playlist' => $video_settings[1]
            ]
          ]
        ];
        $classes .= ' responsive-embed';
        //og code before embed method of youtube auto play
//         $tile_type = '<iframe type="text/html" width="1138" height="640.125"
// src="https://www.youtube.com/embed/' . $video_settings[1] . '?autoplay=1&controls=0&enablejsapi=1&loop=1&modestbranding=1&fs=0" frameborder="0"></iframe>';
//         $classes .= ' responsive-embed';
      }
    }
    return '        <div id="news-' . $news_feat->posts[$target_num]->ID . '" class="black-border thick-border tile relative maximum-height">
          <a href="' . get_permalink($news_feat->posts[$target_num]->ID) . '" class="' . $classes . '">' . $tile_type . '</a>
          <h1 class="article-info">
            <a href="' . get_permalink($news_feat->posts[$target_num]->ID) . '">' . $news_feat->posts[$target_num]->post_title . '</a>' . 
            (( !empty($news_feat->posts[$target_num]->post_excerpt) ) ? "<p class=\"no-margin cute orange text-lowercase\">" . $news_feat->posts[$target_num]->post_excerpt . "</p>" : "") . 
          '</h1>
        </div>';
  } ?>

<!-- <div class="hide-for-small-only" >
    <video style="height:100%; width:100%;"  controls autoplay="true" loop="true" muted>
      <source src='/wp-content/themes/scscholastic-press/assets/videos/Scholastic-Banner.mp4' type='video/mp4'>
      Your browser does not support the video tag.
    </video>
</div>

<div class="show-for-small-only">
    <video style="height:100%; width:100%;"  autoplay="true" loop="true" muted  playsinline autoplay>
      <source src='/wp-content/themes/scscholastic-press/assets/videos/Scholastic-Banner.mp4' type='video/mp4'>
      Your browser does not support the video tag.
    </video>
</div> -->

    <div class="parent">

<!--       <img class="" src="<?php echo ( has_post_thumbnail() ) ? the_post_thumbnail_url( 'featured-home' ) : 'http://image.mlive.com/home/mlive-media/width960/img/kalamazoogazette/photo/2016/12/22/-c8733c1e608c238b.JPG'; ?>" alt="<?php echo get_the_title(); ?>"
      /> -->
<!--       hello-->
      <figure class=" size-full is-resized">
        <img srcset="<?php echo $smallBG ?> 1920w, <?php echo $bigBG ?> 2400w" src="<?php $smallBG ?>"  alt="" class="wp-image-51" />
      </figure>

      <div class="parent-2 ">
        
        <div class="grid-x align-center">
         <img class="img-2" src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/Scholastic-Series-logo.png">
        </div>
        
        
        
       <dev>
          <h1 class="three-motto" style="color:#fefefe;">
            EXPOSURE • DEVELOPMENT • COMPETITION
          </h1>
        
        </dev>
        
        
        
<!--         <p class="hero__sub-heading text-center tiny-margin-top">EVENTS</p> -->
        
        
        
<!--         <p class="hero__sub-heading tiny-margin-bottom text-center">Presented By</p> -->
<!--         <div class="grid-x align-center"> -->
<!--             <a class="img-3 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://elitebasketballcircuit.com/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/ebc_tiny_dk.png"></a>   -->
<!--             <a class="img-5 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://opengympremier.com/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/open_gym_premier_tiny_dk.png"></a> -->
<!--             <a class="img-4" target="_blank" rel="noopener noreferrer" href="https://grassroots365.com/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/grassroots_365_tiny_dk-stroke.png"></a>   -->
<!--             <a class="img-6 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://grassroots365.com/"><img src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/grassroots_365_tiny_dk-stroke.png"></a> -->
        </div>
      </div>

<!-- new tiles -->
 <section class="site-main width-hd hero-tiles<?php if ( $scscholastic_ad_info['go'] ) echo $scscholastic_ad_info['ad_section_class']; ?>">
    <?php if ( $scscholastic_ad_info['go'] ) echo $scscholastic_ad_info['ad_before'] . $scscholastic_ad_info['ad_content'] . $scscholastic_tile_banner_build['ad_after']; ?>
    <div class="grid-x white-border thick-border" style="overflow-x:scroll; flex-wrap: nowrap;">
  
            <div class="cell small-4 maximum-height">
              <?php echo scscholastic_tile_template( 0, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo scscholastic_tile_template( 1, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo scscholastic_tile_template( 2, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo scscholastic_tile_template( 3, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo scscholastic_tile_template( 4, $news_feat, 'tile-image' ); ?>
            </div>
            <div class="cell small-4 maximum-height">
              <?php echo scscholastic_tile_template( 5, $news_feat, 'tile-image' ); ?>
            </div>
        <?php if( $scscholastic_tile_banner_build !== '' ) : ?>
        <div class="cell shrink">
          <div class="grid-x maximum-height">
            <div class="cell small-12 text-center small-small-padding large-padding callout secondary no-margin white-border thick-border">
              <?php echo $scscholastic_tile_banner_build; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
  </div>
    
<!-- <div style="text-align: right; margin-right: 2rem;">

<button class="button slider-btn" id="newsLeft" disabled><</button>
<button class="button slider-btn" id="newsRight">></button>
</div> -->
  </section>



<!--  old tiles -->
<!--   <section class="site-main width-hd hero-tiles<?php if ( $scscholastic_ad_info['go'] ) echo $scscholastic_ad_info['ad_section_class']; ?>">
    <?php if ( $scscholastic_ad_info['go'] ) echo $scscholastic_ad_info['ad_before'] . $scscholastic_ad_info['ad_content'] . $scscholastic_ad_info['ad_after']; ?>
    <div class="grid-x black-border thick-border">
      <div class="cell medium-8">
        <div class="grid-y grid-frame small-block">
          <div class="cell auto">
            <div class="grid-x maximum-height">
              <div class="cell small-6 maximum-height">
                <?php echo scscholastic_tile_template( 0, $news_feat, 'tile-image' ); ?>
              </div>
              <div class="cell small-6 maximum-height">
                <?php echo scscholastic_tile_template( 1, $news_feat, 'tile-image' ); ?>
              </div>
            </div>
          </div>
          <?php if( $scscholastic_tile_banner_build !== '' ) : ?>
          <div class="cell shrink">
            <div class="grid-x maximum-height">
              <div class="cell small-12 text-center small-small-padding large-padding callout secondary no-margin black-border thick-border">
                <?php echo $scscholastic_tile_banner_build; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <div class="cell auto">
            <div class="grid-x maximum-height">
              <div class="cell small-6 maximum-height">
                <?php echo scscholastic_tile_template( 2, $news_feat, 'tile-image' ); ?>
              </div>
              <div class="cell small-6 maximum-height">
                <?php echo scscholastic_tile_template( 3, $news_feat, 'tile-image' ); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cell medium-4">
        <div class="grid-x">
          <div class="cell small-6 medium-12">
            <?php echo scscholastic_tile_template( 4, $news_feat, 'tile-image' ); ?>
          </div>
          <div class="cell small-6 medium-12">
            <?php echo scscholastic_tile_template( 5, $news_feat, 'tile-image' ); ?>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <?php
  //$featured_events_arr = g365_conn( 'g365_display_events', [65, 6] );
  $scscholastic_potm = get_post_meta($post->ID, 'scscholastic_potm', true);
  $scscholastic_ctotm = get_post_meta($post->ID, 'scscholastic_ctotm', true);
  if( !empty( $scscholastic_potm ) || !empty( $scscholastic_ctotm ) || !empty( $featured_events_arr ) ) :
?>
    <section class="site-main small-padding-top xlarge-padding-bottom grid-container">
      <div class="grid-x">
        <div id="main" class="small-12 cell">
          <?php if( !empty($featured_events_arr) ) : ?>
          <div class="tiny-padding gset no-border">
            <h2 class="entry-title text-center screen-reader-text"><a href="/calendar">Featured Events</a></h2>
          </div>
          <div class="widget-wrapper medium-margin-bottom">
            <div class="grid-x small-up-2 medium-up-3 large-up-6 text-center profile-feature profile-widget">
              <?php foreach( $featured_events_arr as $dex => $obj ) : ?>
              <div class="cell">
                <div class="small-margin-bottom">
                  <a href="<?php echo $obj->link; ?>" target="_blank">
                <img src="<?php echo (!empty($obj->logo_img)) ? $obj->logo_img : $default_event_img ?>" alt="<?php echo $obj->name; ?> official logo" />
                <p>
                  <?php echo ( empty($obj->short_name) ) ? $obj->name : $obj->short_name; ?><br>	
                  <small class="tiny-margin-top block"><?php echo scscholastic_build_dates($obj->dates); ?></small>
                </p>
              </a>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <a class="button expanded no-margin-bottom" href="/calendar">Full Calendar</a>
          </div>
          <?php endif;
      if( !empty($scscholastic_potm) ) : ?>
          <div class="widget-wrapper medium-margin-bottom">
            <div class="grid-x">
              <div class="cell">
                <img src="<?php echo $scscholastic_potm; ?>" alt="Players of the month by region. <?php the_modified_date(); ?>" />
              </div>
            </div>
          </div>
          <?php endif; ?>
          <?php if( !empty($scscholastic_ctotm) ) : ?>
          <div class="widget-wrapper medium-margin-bottom">
            <div class="grid-x">
              <div class="cell">
                <img src="<?php echo $scscholastic_ctotm; ?>" alt="Club Team of the month. <?php the_modified_date(); ?>" />
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <?php endif; //end ptom section ?>

    <?php } else { //end tile layout hero section, begin standard featured post rotator ?>

    <!--  add the main image here to display-->


    <!--        ------------------------------------------------------------------------------------------------------>



    <?php if ( $scscholastic_ad_info['go'] ) echo $scscholastic_ad_info['ad_before'] . $scscholastic_ad_info['ad_content'] . $scscholastic_ad_info['ad_after']; ?>

    <?php if ( $news_feat -> have_posts() ) : while ( $news_feat -> have_posts() ) : $news_feat -> the_post(); ?>

    <div class="parent">

<!--       <img class="" src="<?php echo ( has_post_thumbnail() ) ? the_post_thumbnail_url( 'featured-home' ) : 'http://image.mlive.com/home/mlive-media/width960/img/kalamazoogazette/photo/2016/12/22/-c8733c1e608c238b.JPG'; ?>" alt="<?php echo get_the_title(); ?>"
      /> -->
<!--       hello-->
      <figure class=" size-full is-resized">
        <img srcset="<?php echo $smallBG ?> 1920w, <?php echo $bigBG ?> 2400w" src="<?php $smallBG ?>"  alt="" class="wp-image-51" />
      </figure>

      <div class="parent-2 ">
        
        <div class="grid-x align-center">
         <img class="img-2" src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/Scholastic-Series-logo.png">
        </div>
        
        
        
       
        
        
        
<!--         <p class="hero__sub-heading text-center tiny-margin-top">EVENTS</p> -->
        
        
        
<!--         <p class="hero__sub-heading tiny-margin-bottom text-center">Presented By</p> -->
<!--         <div class="grid-x align-center"> -->
<!--             <a class="img-3 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://elitebasketballcircuit.com/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/ebc_tiny_dk.png"></a>   -->
<!--             <a class="img-5 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://opengympremier.com/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/open_gym_premier_tiny_dk.png"></a> -->
<!--             <a class="img-4" target="_blank" rel="noopener noreferrer" href="https://grassroots365.com/"><img  src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/grassroots_365_tiny_dk-stroke.png"></a>   -->
<!--             <a class="img-6 grid-x align-center" target="_blank" rel="noopener noreferrer" href="https://grassroots365.com/"><img src="<?php echo get_site_url(); ?>/wp-content/themes/scscholastic-press/assets/tiny-logos/grassroots_365_tiny_dk-stroke.png"></a> -->
        </div>
      </div>
    </div>

      <?php endwhile; wp_reset_postdata(); endif; ?>



      <!--        ------------------------------------------------------------------------------------------------------>





      <?php } //end default hero featured image section ?>

      <section id="content" class="site-main small-padding-top xlarge-padding-bottom grid-container">

        <?php //if we have page content
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php the_content(); ?>

        <?php endwhile; endif; ?>

      </section>

      <?php
//if we have a splash graphic, add  the elements to support, part 1
if( !empty($scscholastic_ad_info['splash']) ) echo $scscholastic_ad_info['splash'];

get_footer();

//if we have a splash graphic, initialize it now that foundation() has started, part 2
if( !empty($scscholastic_ad_info['splash']) ) echo '<script type="text/javascript">
    var scscholastic_closed = localStorage.getItem("scscholastic_close_today");
    var scscholastic_closed_date = localStorage.getItem("scscholastic_close_today_date");
    var scscholastic_now_date = new Date();
    if( scscholastic_closed_date !== null && new Date(scscholastic_closed_date).getDate() !== scscholastic_now_date.getDate() ) {
      localStorage.removeItem("scscholastic_close_today");
      localStorage.removeItem("scscholastic_close_today_date");
      scscholastic_closed = null;
    }
    if( scscholastic_closed === null ) {
      (function($){$("#scscholastic_home_reveal").foundation("open");})(jQuery);
    }
  </script>';

if( $tile_vid ) {
  print_r(
    '<script>
      var tag = document.createElement("script");
      tag.src = "https://youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName("script")[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      var tile_players = ' . json_encode( $tile_video_settings) . ';
      function onYouTubeIframeAPIReady() {
        tile_players.forEach( function( vid_settings, dex ) {
          vid_settings.data.events = {
            "onReady": onPlayerReady,
            "onStateChange": onPlayerStateChange
          };
          tile_players[dex]["video_ref"] = new YT.Player( vid_settings.id, vid_settings.data);
        });
      }
       function onPlayerReady(event) {
         event.target.playVideo();
         event.target.mute();
       }
       function onPlayerStateChange(event) {
        if( event.data === 0 ){
         event.target.playVideo();
        }
       }
    </script>'
  );
}

    
    
    
?>