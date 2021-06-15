<?php


namespace Kenhana\App;


class Shortcodes {
	private static $instance;
	public function __construct() {
		//social post share
		add_shortcode('appside_post_share', [$this, 'post_share']);
	}

	public function getInstance() {
		if (null==self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function post_share($atts, $content=null) {
		extract(shortcode_atts([
			'custom_class' => '',
		], $atts));

		global $post;
		$output='';
		if (is_singular() || is_home()) {
			// get current page url
			$appside_url = urlencode_deep(get_permalink());
			$appside_title = str_replace(' ', '%20', get_the_title($post->ID));
			$appside_thumbail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

			$facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $appside_url;
			$twitter_share_link = 'https://twitter.com/intent/tweet?text=' . $appside_title . '&amp;url=' . $appside_url . '&amp;via=Crunchify';
			$linkedin_share_link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $appside_url . '&amp;title=' . $appside_title;
			$pinterest_share_link = 'https://pinterest.com/pin/create/button/?url=' . $appside_url . '&amp;media=' .$appside_thumbail[0].'&amp;description='.$appside_title;
			$output = '';
			$output .= '<ul class="social-share">';
			$output .= '<li class="title">'.esc_html('Share:').'</li>';
			$output .= '<li><a class="facebook" href="'.esc_url($facebook_share_link).'"><i class="fa fa-facebook-f"></i></a></li>';
			$output .= '<li><a class="twitter" href="'.esc_url($twitter_share_link).'"><i class="fa fa-twitter"></i></a></li>';
			$output .= '<li><a class="linkedin" href="'.esc_url($linkedin_share_link).'"><i class="fa fa-linkedin"></i></a></li>';
			$output .= '<li><a class="pinterest" href="'.esc_url($pinterest_share_link).'"><i class="fa fa-pinterest-p"></i></a></li>';
			$output .= '</ul>';

			return $output;
		}
	}
}