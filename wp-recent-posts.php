<?php
/*
Plugin Name: WP Recent Posts
description: WP Recent Posts plugin will displays recent posts with date, excerpt and title in Posts, Pages, Widgets and custom post types.
Version: 1.3
Author: Boopathi Rajan
Author URI: http://www.boopathirajan.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/



function wp_recent_posts($atts)
{
 $atts = shortcode_atts(array('count' => '5'), $atts, 'wp_recent_posts' );
 echo '<style>.recent-blog-post-home-content > h3 {
    font-size: 18px;
    font-weight: bold;
    margin: 0;
}
.recent-blog-post-home-content > h6 {
    font-style: italic;
    margin: 10px 0 !important;
	}
	.recent-blog-post-home
	{
	width:100%;
	}
	.recent-blog-post-home-content
	{
	  width: 57%; float: left;
	}
	.recent-blog-post-home-content p
	{
	   text-align: 
	   justify; float: left;
	   line-height:18px;
	}
	.recent-blog-post-home img
	{
	float: left; width: 40%; height: auto; margin-right: 3%; overflow: hidden;
	}
	.rm-link {
	 display: block;
	 text-align: right;
	 color: #f48a4c;
	 font-size: 15px;	 
	 margin-top: 5px;
	}
	
	.rm-link:hover {
	 color: #f48a4c;
	 text-decoration: none;
	 opacity: 0.8;
	}
	
	</style>';

	
	$args = array(
    'numberposts' => $atts['count'],
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish'
    );

    $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
	foreach($recent_posts as $recent)
	{
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($recent["ID"]), 'javo-large' );
	$content=strip_tags(get_post_field('post_content', $recent["ID"]));
	if (strlen($content) > 300) 
	{
		// truncate string
		$stringCut = substr(strip_shortcodes($content), 0, 300);
		// make sure it ends in a word so assassinate doesn't become ass...
		$content = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="'.get_post_permalink($recent["ID"]).'" class="rm-link">Read More &gt;&gt;</a>'; 
	}
	
        echo '<div class="vc_col-sm-6 wpb_column vc_column_container ">
		
			<div class="recent-blog-post-home">
			<div class="recent-blog-post-home-img">
				<a href="'.get_post_permalink($recent["ID"]).'"><img alt="" src="'.$thumb[0].'" /></a>
					<div class="javo-sns-wrap recent-blog-share social-wrap">
						<i class="sns-facebook" data-title="'.get_the_title($recent["ID"]).'" data-url="'.get_post_permalink($recent["ID"]).'">
							<a class="facebook javo-tooltip" title="Share Facebook"></a>
						</i>
						<i class="sns-twitter" data-title="'.get_the_title($recent["ID"]).'" data-url="'.get_post_permalink($recent["ID"]).'">
							<a class="twitter javo-tooltip" title="Share Twitter"></a>
						</i>
					</div>				
			</div>
			<div class="recent-blog-post-home-content">
			 <h3><a href="'.get_post_permalink($recent["ID"]).'">'.get_the_title($recent["ID"]).'</a></h3>
			 <h6>'.get_the_date("d-m-Y",$recent["ID"]).'</h6>
             <p>'.$content.'</p>

			</div>
		</div> 
	</div>';
	}
}

add_shortcode('wp_recent_posts','wp_recent_posts');
?>