<?php


namespace Kenhana\App;


class Init_Shortcodes {
	private static $instance;

	public function __construct() {
		// load plugin asset
		add_action('wp_enqueue_scripts', [$this, 'plugin_assets']);
		add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
		add_action('init', [$this, 'load-textdomain']);
		// load plugin dependencies
		add_action('plugin_loaded', [$this, 'load_plugin_dependency_files']);
	}

	public static function getInstance() {
		if (null == self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function load_plugin_dependency_files() {
//		$includes_files = [
//			[
//				'file-name' => 'codestar-framework',
//				'folder-name' => APPSIDE_MASTER_LIB . '/codestar-framework'
//			],
//			[
//				'file-name' => 'class-menu-page',
//				'folder-name' => APPSIDE_MASTER_ADMIN
//			],
//			[
//				'file-name' => 'class-custom-post-type',
//				'folder-name' => APPSIDE_MASTER_ADMIN
//			],
//			[
//				'file-name' => 'class-post-column-customize',
//				'folder-name' => APPSIDE_MASTER_ADMIN
//			],
//			[
//				'file-name' => 'class-admin-request',
//				'folder-name' => APPSIDE_MASTER_ADMIN
//			],
//			[
//				'file-name' => 'add-menu-item-custom-fields',
//				'folder-name' => APPSIDE_MASTER_LIB . '/mega-menu'
//			],
//			[
//				'file-name' => 'class-appside-shortcodes',
//				'folder-name' => APPSIDE_MASTER_INC
//			]
//		];
	}

	public function plugin_assets() {
		$this->load_plugin_css_files();
		$this->load_plugin_js_files();
	}

	public function admin_assets() {
		$this->load_admin_css_files();
		$this->load_admin_js_files();
	}

	private function load_plugin_css_files() {
		$plugin_version = APPSIDE_MASTER_ENV ? time() : APPSIDE_MASTER_VERSION;
		$all_css_files = [
			[
				'handle' => 'flaticon',
				'src' => APPSIDE_MASTER_CSS .'/flaticon.css',
				'deps' => [],
				'ver' =>$plugin_version,
				'media' => 'all'
			],
			[
				'handle' => 'ir-icon',
				'src' => APPSIDE_MASTER_CSS . '/ir-icon.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			],
			[
				'handle' => 'xg-icon',
				'src' => APPSIDE_MASTER_CSS .'/xg-icons.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			],
			[
				'handle' => 'oxo-icons',
				'src' =>  APPSIDE_MASTER_CSS .'/oxo-icon.css',
				'deps' => [],
				'ver' =>  $plugin_version,
				'media' => 'all'
			],
			[
				'handle' => 'owl-carousel',
				'src' => APPSIDE_MASTER_CSS .'/owl.carousel.min.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			],
			[
				'handle' => 'appside-master-main-style',
				'src' => APPSIDE_MASTER_CSS . '/main-style.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			]
		];

		if (!APPSIDE_THEME_ACTIVE) {
			$all_css_files[] = [
				'handle' => 'animate',
				'src' => APPSIDE_MASTER_CSS . '/animate.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			];
			$all_css_files[] = [
				'handle' => 'bootstrap',
				'src' => APPSIDE_MASTER_CSS . '/bootstrap.min.cs',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			];
			$all_css_files[] = [
				'handle' => 'magnific-popup',
				'src' => APPSIDE_MASTER_CSS .'/magnific-popup.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			];
			$all_css_files[] = [
				'handle' => 'font-awesome',
				'src' => APPSIDE_MASTER_CSS .'/font-awesome.min.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			];
			$all_css_files[] = [
				'handle' => 'appside-theme-main-style',
				'src' => APPSIDE_MASTER_CSS .'/theme-main-style.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			];
			$all_css_files[] = [
				'handle' => 'appside-responsive',
				'src' => APPSIDE_MASTER_CSS .'/responsive.css',
				'deps' => [],
				'ver' => $plugin_version,
				'media' => 'all'
			];
		}

		$all_css_files = apply_filters('appside_master_css', $all_css_files);
		if (is_array($all_css_files) && !empty($all_css_files)) {
			foreach ( $all_css_files as $all_css_file ) {
				call_user_func('wp_enqueue_style', $all_css_file);
			}
		}
	}

	private function load_plugin_js_files() {
		$plugin_version = APPSIDE_MASTER_VERSION;
		$all_js_files = [
			[
				'handle' => 'waypoints',
				'src' => APPSIDE_MASTER_JS . '/waypoints.min.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			],
			[
				'handle' => 'counterup',
				'src' =>  APPSIDE_MASTER_JS .'/jquery.counterup.min.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			],
			[
				'handle' => 'owl-carousel',
				'src' => APPSIDE_MASTER_JS .'/owl.carousel.min.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			],
			[
				'handle' => 'imagesloaded',
				'src' => APPSIDE_MASTER_JS .'/imagesloaded.pkgd.min.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			],
			[
				'handle' => 'isotype',
				'src' => APPSIDE_MASTER_JS .'/isotope.pkgd.min.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			],
			[
				'handle' => 'appside-master-main-script',
				'src' => APPSIDE_MASTER_JS .'/main.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			]
		];

		if (!APPSIDE_THEME_ACTIVE) {
			$all_js_files[] = [
				'handle' => 'popper',
				'src' =>  APPSIDE_MASTER_JS .'/popper.min.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			];

			$all_js_files[] =[
				'handle' => 'bootstrap',
				'src' => APPSIDE_MASTER_JS .'/bootstrap.min.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			];

			$all_js_files[] = [
				'handle' => 'magnific-popup',
				'src' => APPSIDE_MASTER_JS .'/jquery.magnific-popup.js',
				'deps' => ['query'],
				'ver' => $plugin_version,
				'in_footer' => true
			];
		}

		$all_js_files = apply_filters('appside_master_js',$all_js_files);
		if (is_array($all_js_files) && !empty($all_js_files)){
			foreach ($all_js_files as $js){
				call_user_func_array('wp_enqueue_script',$js);
			}
		}

	}

	private function load_admin_js_files() {
		$plugin_version = APPSIDE_MASTER_VERSION;
		$all_js_files = [
			[
				'handle' => 'appside-master-widget',
				'src' =>  APPSIDE_MASTER_ADMIN_ASSETS .'/js/widget.js',
				'deps' => ['jquery'],
				'ver' => $plugin_version,
				'in_footer' => true
			]
		];

		$all_js_files = apply_filters('appside_admin_js',$all_js_files);
		if (is_array($all_js_files) && !empty($all_js_files)){
			foreach ($all_js_files as $js){
				call_user_func_array('wp_enqueue_script',$js);
			}
		}
	}

	private function load_admin_css_files() {
	}


}