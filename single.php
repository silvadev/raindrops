<?php
/**
 * Template for single post.
 *
 *
 * @package Raindrops
 * @since Raindrops 0.306
 * @uses raindrops_show_one_colum   Detect current post column count
 * @uses add_filter                 Overwrite Color type func raindrops_color_type_custom()
 * @uses get_header( $raindrops_document_type )       Include template part file
 * @uses have_posts()
 * @uses the_post()
 * @uses in_category()
 * @uses get_the_post_thumbnail()
 * @uses has_post_thumbnail()
 * @uses wp_get_attachment_image_src()
 * @uses esc_url()
 * @uses round()
 * @uses esc_attr()
 * @uses image_hwstring()
 * @uses switch()
 * @uses get_template_part()
 * @uses raindrops_show_one_column()
 * @uses next_posts_link()
 * @uses previous_posts_link()
 * @uses get_sidebar()
 * @uses get_footer( $raindrops_document_type )
 *
 *
 */
$raindrops_current_column = raindrops_show_one_column();

if($raindrops_current_column !== false){
add_filter("raindrops_theme_settings__raindrops_indv_css","raindrops_color_type_custom");
}


get_header( $raindrops_document_type ); ?>
<?php if(WP_DEBUG == true){echo '<!--'.basename(__FILE__,'.php').'['.basename(dirname(__FILE__)).']-->';}?>
<div id="yui-main">
<div class="yui-b" <?php if($raindrops_current_column == '1' ){
    echo "style=\"width:100%;margin-left:0;\"";}?>>
    <div class="<?php echo raindrops_yui_class_modify();?>" id="container">
	
<div class="yui-u first"
<?php
if($raindrops_current_column == 3){

}elseif($raindrops_current_column == 1){
    echo 'style="width:99%;"';
}elseif($raindrops_current_column == 2){

    echo 'style="width:99%;"';
}elseif($raindrops_current_column == false){
    is_2col_raindrops('style="width:99%;"');
}
?>>
<?php
/**
 * Display navigation to next/previous pages when applicable
 */
//raindrops_prev_next_post();?>
<?php if(have_posts()){
/**
 * when Single page
 */
 while (have_posts()){
    the_post();

    $cat = "default";
    if ( in_category( "blog" )){    $cat = "blog";      }
    if ( in_category( "gallery" )){ $cat = "gallery";   }

    if(WP_DEBUG == true){
        echo '<!--Single Category '.$cat.' start-->';
    }
	if($cat == "blog" or $cat == "gallery"){?>
<div id="post-<?php the_ID(); ?>" <?php  post_class('clearfix'); ?>>
<?php
}
/**
 * Show featured image
 *
 *
 *
 *
 */
    $thumb = get_the_post_thumbnail($post->ID,'single-post-thumbnail');

    if(has_post_thumbnail() and isset($thumb) and $is_IE){
    /*IE8 img element has width height attribute. and style max-width and height auto makes conflict expand height*/
            $thumbnailsrc       = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-post-thumbnail');
            $thumbnailuri       = esc_url($thumbnailsrc[0]);
            $thumbnailwidth     = $thumbnailsrc[1];


        if($thumbnailwidth > $content_width){
            $thumbnailheight    = $thumbnailsrc[2];
            $ratio              = round(RAINDROPS_SINGLE_POST_THUMBNAIL_HEIGHT/ RAINDROPS_SINGLE_POST_THUMBNAIL_WIDTH,2);
            $ie_height          = round($content_width * $ratio);

            $thumbnail_title    = basename($thumbnailsrc[0]);
            $thumbnail_title    = esc_attr($thumbnail_title);
            $size_attribute     = image_hwstring($content_width, $ie_height);

            echo '<div class="single-post-thumbnail">';
            echo '<img src="'.$thumbnailuri.'" '.$size_attribute.'" alt="'.$thumbnail_title.'" style="max-width:100%;" />';
            echo '</div>';

        }else{
            echo '<div class="single-post-thumbnail">';
            echo $thumb;
            echo '</div>';
        }

    }else{
		$raindrops_post_thubnail_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );

        if(!empty($thumb)){
            echo '<div class="single-post-thumbnail">';
			echo '<a href="#raindrops-light-box" class="raindrops-light-box">';
            echo $thumb;
			echo '</a>';
            echo '</div>';
			/* for light box */
			echo '<div class="raindrops-lightbox-overlay" id="raindrops-light-box">';
			echo '<a href="#page" class="lb-close">Close</a>';
			echo '<img src="'.$raindrops_post_thubnail_src[0].'" alt="single post thumbnail" />';
			echo '</div>';
        }
    }

/**
 * Show Category base special layout and default single template part
 *
 *
 *
 *
 */
    switch($cat){

        case ('blog'): //category blog
            get_template_part("part","blog");
            break;
// category gallery
        case("gallery"):
            get_template_part("part","gallery");
            break;
//another single page
        default:
        get_template_part("part");

        if(WP_DEBUG == true){
        echo '<!-- #post-'.get_the_ID().' -->';
        }
    }//   end switch($cat)
	
if($cat == "blog" or $cat == "gallery"){?>
</div>
<?php
}
}//　endwhile             ?>
<?php
/**
 * Next Previous post link
 *
 *
 *
 *
 */

if ( $wp_query->max_num_pages > 1 ){ ?>
<div id="nav-below" class="clearfix"> <span class="nav-previous">
<?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'Raindrops' ) ); ?>
</span> <span class="nav-next">
<?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'Raindrops' ) ); ?>
</span> </div>
<!-- #nav-above -->
<?php } }?>
</div>
<?php
/**
 * Show Extra sidebar column rsidebar start
 *
 *
 *
 *
 */
?>

<?php if(raindrops_show_one_column() == 3){?>
<div class="yui-u">
<?php get_sidebar('extra');?>
</div>
<?php
}elseif($rsidebar_show and $raindrops_current_column == false){?>
<div class="yui-u">
<?php get_sidebar('extra');?>
</div>
<?php } ?>


<?php //add nest grid here?>
</div>
<?php //end main ?>
</div>
</div>

<?php
/**
 * Show main column lsidebar start
 *
 *
 *
 *
 */
if(raindrops_show_one_column() !== '1' or $raindrops_current_column == false){?>
<div class="yui-b">
<?php //lsidebar start ?>
<?php get_sidebar('default'); ?>
</div>
<?php }?>

</div>
<?php

/**
 * Inlude Footer template part file
 *
 *
 *
 *
 */

get_footer( $raindrops_document_type ); ?>