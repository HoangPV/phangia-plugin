<?php


namespace Kenhana\App\Helper;


class Data {
	protected static $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function post_thumbnail() {
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()) {
			?>
			<div class="post-thumbnail thumb">
				<?php the_post_thumbnail('appside_classic')?>
			</div>
			<?php
		} else {
			?>
			<div class="thumb">
				<a class="post-thumbnail" href="<?php the_permalink()?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail('appside_classic', [
						'alt' => the_title_attribute([
							'echo' => false
						])
					])
					?>
				</a>
			</div>

			<?php
		}
	}

	public function get_terms_names($taxonomy_name='', $output='', $hide_empty=false) {
		$return_val = [];
		$terms = get_terms([
			'taxonomy' => $taxonomy_name,
			'hide_empty' => $hide_empty
		]);
		foreach ($terms as $term) {
			if ('id' === $output) {
				$return_val[$term->term_id] = $term->name;
			} else {
				$return_val[$term->slug] = $term->name;
			}
		}

		return $return_val;
	}

	public function sanitize_px($value) {
		$return_val = $value;
		if (filter_var($value, FILTER_VALIDATE_INT)) {
			$return_val = $value . 'px';
		}

		return $return_val;
	}

	public function minify_css_lines($css) {
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		preg_match_all( '/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER );
		for ( $i = 0; $i < count( $hit[1] ); $i ++ ) {
			$css = str_replace( $hit[1][ $i ], '##########' . $i . '##########', $css );
		}
		// remove traling semicolon of selector's last property
		$css = preg_replace( '/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css );
		// remove any whitespace between semicolon and property-name
		$css = preg_replace( '/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css );
		// remove any whitespace surrounding property-colon
		$css = preg_replace( '/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css );
		// remove any whitespace surrounding selector-comma
		$css = preg_replace( '/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css );
		// remove any whitespace surrounding opening parenthesis
		$css = preg_replace( '/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css );
		// remove any whitespace between numbers and units
		$css = preg_replace( '/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css );
		// shorten zero-values
		$css = preg_replace( '/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css );
		// constrain multiple whitespaces
		$css = preg_replace( '/\p{Zs}+/ims', ' ', $css );
		// remove newlines
		$css = str_replace( array( "\r\n", "\r", "\n" ), '', $css );
		for ( $i = 0; $i < count( $hit[1] ); $i ++ ) {
			$css = str_replace( '##########' . $i . '##########', $hit[1][ $i ], $css );
		}
		return $css;
	}

	public function is_cs_framework_active() {
		return ( defined( 'CS_VERSION' ) ) ? true : false;
	}

	public function link_pages() {
	    $default = [
            'before' => '<div class="wp-link-pages"><span>' . esc_html('Pages:') . '</span>',
            'after' => '</div>',
            'link_before' => '',
            'link_after' => '',
            'next_or_number' => 'number',
            'separator' => ' ',
            'pagelink' => '%',
            'echo' => 1
        ];
	    wp_link_pages($default);
    }

    public function post_pagination($nav_query=null) {
	    global $wp_query;
	    $big = 12345678;
	    if ( null == $nav_query ) {
		    $page_format = paginate_links([
			    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			    'format'    => '?paged=%#%',
			    'current'   => max( 1, get_query_var( 'paged' ) ),
			    'total'     => $wp_query->max_num_pages,
			    'type'      => 'array',
			    'next_text' => '»',
			    'prev_text' => '«'
            ]);

		    if ( is_array( $page_format ) ) {
			    $paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
			    echo '<div class="blog-pagination margin-top-60"><ul>';
			    echo '<li><span>' . esc_html( $paged ) . esc_html__( ' of ', 'aapside-master' ) . esc_html( $wp_query->max_num_pages ) . '</span></li>';
			    foreach ( $page_format as $page ) {
				    echo "<li>" . wp_kses_post( $page ) . "</li>";
			    }
			    echo '</ul></div>';
		    }
	    } else {
		    $page_format = paginate_links([
			    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			    'format'    => '?paged=%#%',
			    'current'   => max( 1, get_query_var( 'paged' ) ),
			    'total'     => $nav_query->max_num_pages,
			    'type'      => 'array',
			    'next_text' => '»',
			    'prev_text' => '«'
            ]);

		    if ( is_array( $page_format ) ) {
			    $paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
			    echo '<div class="blog-pagination margin-top-60"><ul>';
			    echo '<li><span>' . esc_html( $paged ) . esc_html__( ' of ', 'aapside-master' ) . esc_html( $nav_query->max_num_pages ) . '</span></li>';
			    foreach ( $page_format as $page ) {
				    echo "<li>" . wp_kses_post( $page ) . "</li>";
			    }
			    echo '</ul></div>';
		    }
	    }

    }

    public function posted_on() {
	    $time_string = sprintf( '<time class="entry-date published updated">%1$s</time>', esc_attr( get_the_date() ) );
	    $time_string = sprintf( $time_string,
		    esc_attr( get_the_date( DATE_W3C ) )
	    );
	    $posted_on = sprintf(
		    esc_html_x( ' %s', 'post date', 'aapside-master' ),
		    '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><i class="fa fa-calendar" aria-hidden="true"></i> ' . $time_string . '</a>'
        );

	    echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
    }

    public function posted_by() {
	    $byline = sprintf(
	    /* translators: %s: post author. */
		    esc_html_x( ' %s', 'post author', 'aapside-master' ),
		    '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user-o" aria-hidden="true"></i> ' . esc_html__( 'By ', 'aapside-master' ) . esc_html( get_the_author() ) . '</a></span>'
	    );

	    echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
    }

	public function posted_tag() {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'aapside-master' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<ul class="tags"><li class="title">' . esc_html__( 'Tags: ', 'aapside-master' ) . '</li><li>' . ' %1$s' . '</li></ul>', $tags_list ); // WPCS: XSS OK.
		}
	}

	public function post_navigation() {
		the_post_navigation( array(
			'prev_text' => '<i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;' . esc_html__( 'Prev Post', 'aapside-master' ),
			'next_text' => esc_html__( 'Next Post', 'aapside-master' ) . '&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
		) );
		echo wp_kses_post( '<div class="clearfix"></div>' );
	}

	public function is_home_page() {
	    $check_home_page = true;
	    if (is_home() && is_front_page()) {
		    $check_home_page = true;
        } elseif (is_front_page() && !is_home()) {
		    $check_home_page = true;
        } elseif (is_home() && !is_front_page()) {
	        $check_home_page = false;
        }
		$return_val = $check_home_page;
		return $return_val;
    }

	public function get_terms_by_post_id( $post_id, $taxonomy ) {
		$all_terms     = array();
		$all_term_list = get_the_terms( $post_id, $taxonomy );

		foreach ( $all_term_list as $term_item ) {
			$term_url               = get_term_link( $term_item->term_id, $taxonomy );
			$all_terms[ $term_url ] = $term_item->name;
		}

		return $all_terms;
	}

	/*
		 * kses allowed html
		 * @since 1.0.0
		 * */
	public function kses_allowed_html( $allowed_tags = 'all' ) {
		$allowed_html = array(
			'div'    => array( 'class' => array(), 'id' => array() ),
			'header' => array( 'class' => array(), 'id' => array() ),
			'h1'     => array( 'class' => array(), 'id' => array() ),
			'h2'     => array( 'class' => array(), 'id' => array() ),
			'h3'     => array( 'class' => array(), 'id' => array() ),
			'h4'     => array( 'class' => array(), 'id' => array() ),
			'h5'     => array( 'class' => array(), 'id' => array() ),
			'h6'     => array( 'class' => array(), 'id' => array() ),
			'p'      => array( 'class' => array(), 'id' => array() ),
			'span'   => array( 'class' => array(), 'id' => array() ),
			'i'      => array( 'class' => array(), 'id' => array() ),
			'mark'   => array( 'class' => array(), 'id' => array() ),
			'strong' => array( 'class' => array(), 'id' => array() ),
			'br'     => array( 'class' => array(), 'id' => array() ),
			'b'      => array( 'class' => array(), 'id' => array() ),
			'em'     => array( 'class' => array(), 'id' => array() ),
			'del'    => array( 'class' => array(), 'id' => array() ),
			'ins'    => array( 'class' => array(), 'id' => array() ),
			'u'      => array( 'class' => array(), 'id' => array() ),
			's'      => array( 'class' => array(), 'id' => array() ),
			'nav'    => array( 'class' => array(), 'id' => array() ),
			'ul'     => array( 'class' => array(), 'id' => array() ),
			'li'     => array( 'class' => array(), 'id' => array() ),
			'form'   => array( 'class' => array(), 'id' => array() ),
			'select' => array( 'class' => array(), 'id' => array() ),
			'option' => array( 'class' => array(), 'id' => array() ),
			'img'    => array( 'class' => array(), 'id' => array() ),
			'a'      => array( 'class' => array(), 'id' => array(), 'href' => array() ),
		);

		if ( 'all' == $allowed_tags ) {
			return $allowed_html;
		} else {
			if ( is_array( $allowed_tags ) && ! empty( $allowed_tags ) ) {
				$specific_tags = array();
				foreach ( $allowed_tags as $allowed_tag ) {
					if ( array_key_exists( $allowed_tag, $allowed_html ) ) {
						$specific_tags[ $allowed_tag ] = $allowed_html[ $allowed_tag ];
					}
				}

				return $specific_tags;
			}
		}

	}

	public function get_theme_info($type = 'name') {
		$theme_information = [];

		if ( is_child_theme() ) {
			$theme      = wp_get_theme();
			$parent     = $theme->get( 'Template' );

			$theme_info = wp_get_theme( $parent );
        } else {
			$theme_info = wp_get_theme();
        }
		$theme_information['THEME_NAME']       = $theme_info->get( 'Name' );
		$theme_information['THEME_VERSION']    = $theme_info->get( 'Version' );
		$theme_information['THEME_AUTHOR']     = $theme_info->get( 'Author' );
		$theme_information['THEME_AUTHOR_URI'] = $theme_info->get( 'AuthorURI' );
		switch ( $type ) {
			case ( "name" ):
				$return_val = $theme_information['THEME_NAME'];
				break;
			case ( "version" ):
				$return_val = $theme_information['THEME_VERSION'];
				break;
			case ( "author" ):
				$return_val = $theme_information['THEME_AUTHOR'];
				break;
			case ( "author_uri" ):
				$return_val = $theme_information['THEME_AUTHOR_URI'];
				break;
			default:
				$return_val = $theme_information;
				break;
		}

		return $return_val;
    }

	public function page_id() {
		global $post, $wp_query;
		$page_type_id = ( isset( $post->ID ) && in_array( $post->ID, self::get_pages_id() ) ) ? $post->ID : false;
		if ( false == $page_type_id ) {
			$page_type_id = isset( $wp_query->post->ID ) ? $wp_query->post->ID : false;
		}
		$page_id = ( isset( $page_type_id ) ) ? $page_type_id : false;
		$page_id = is_home() ? get_option( 'page_for_posts' ) : $page_id;
		return $page_id;

	}

	public function is_appside_active() {
	    $theme_name_array = ['Aapside', 'Aapside Child'];
	    $current_theme = wp_get_theme();
	    $current_theme_name = $current_theme->get('Name');
	    return in_array($current_theme_name, $theme_name_array)? true: false;
    }

    public function is_appside_master_active() {
	    return defined('APPSIDE_MASTER_SELF_PATH') ? true:false;
    }

    public function get_post_list_by_post_type($post_type) {
	    $return_val = [];
	    $args = [
            'post_type' => $post_type,
            'post_per_pages' => -1
        ];

	    $all_post = new \WP_Query($args);

	    while ($all_post->have_posts()) {
	        $all_post->the_post();
	        $return_val[get_the_ID()] = get_the_title();
        }

        return $return_val;
    }

    public function render_elementor_content($content=null) {
	    $return_val = '';
	    if (defined('ELEMENTOR_VERSION')) {
	        $el_plugin_instance = \Elementor\Plugin::instance();
	        $return_val = $el_plugin_instance->frontend->get_builder_content($content);
        }

	    return $return_val;
    }

    public function get_nav_menu_list($output='slug') {
	    $return_val = '';
	    $all_menu_list = wp_get_nav_menus();
	    foreach ($all_menu_list as $menu) {
	        if ($output=='slug') {
	            $return_val[$menu->slug] = $menu->name;
            } else {
	            $return_val[$menu->term_id] = $menu->name;
            }
        }

	    return $return_val;
    }
}