<?php
	if(!class_exists('Blaize_Welcome')) {
		class Blaize_Welcome{

			/** Useful Variables **/
			public $theme_name = '';
			public $theme_ver = '';
			public $tabs = array();
			public $plugins = array();

			public function __construct() {
				
				/** Assigning Default Values to Variables **/
				$theme = wp_get_theme();
				$this->theme_ver = $theme->Version;
				$this->theme_name = $theme->Name;

				$this->tabs = array(
					'general_information' => __('General Information', 'blaize'),
					'plugins_required' => __('Plugins Recommended', 'blaize'),
					'import_demo' => __('Import Demo', 'blaize'),
				);

				$this->plugins = array(
					'blaize-companion' => array(
						'slug' => 'blaize-companion',
						'class' => 'Blaize_Companion',
						'filename' => 'blaize-companion.php',
					),
					'contact-form-7' => array(
						'slug' => 'contact-form-7',
						'class' => 'WPCF7',
						'filename' => 'wp-contact-form-7.php',
					),
					'newsletter' => array(
						'slug' => 'newsletter',
						'class' => 'Newsletter',
						'filename' => 'plugin.php',
					),
					'siteorigin-panels' => array(
						'slug' => 'siteorigin-panels',
						'class' => 'SiteOrigin_Panels',
						'filename' => 'siteorigin-panels.php',
					),
					'so-widgets-bundle' => array(
						'slug' => 'so-widgets-bundle',
						'class' => 'SiteOrigin_Widgets_Bundle',
						'filename' => 'so-widgets-bundle.php',
					),
					'woocommerce' => array(
						'slug' => 'woocommerce',
						'class' => 'WooCommerce',
						'filename' => 'woocommerce.php',
					),
				);

				/** **/
				add_action( 'after_switch_theme', array( $this, 'after_switch_theme_cb' ) );

				/** Necessary Hooks **/
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
				add_action( 'admin_menu', array( $this, 'register_menu' ) );

				/** Ajaxes **/
				add_action( 'wp_ajax_plugin_installer', array( $this, 'plugin_installer_callback' ) );
				add_action( 'wp_ajax_plugin_activator', array( $this, 'plugin_activate_callback' ) );
				add_action( 'wp_ajax_plugin_deactivator', array( $this, 'plugin_deactivate_callback' ) );

			}

			public function after_switch_theme_cb() {
				if($this->theme_ver >= '1.1.3' ){
					wp_redirect('themes.php?page=welcome');
				}
			}

			public function enqueue_styles() {
				wp_enqueue_script( 'welcome', get_template_directory_uri() . '/welcome/js/welcome.js', array('jquery') );
				$localizes = array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'installer_nonce'	=> wp_create_nonce('plugin_installer_nonce'),
					'activator_nonce'	=> wp_create_nonce('plugin_activator_nonce'),
					'deactivator_nonce'	=> wp_create_nonce('plugin_deactivator_nonce'),
					'installed_btn' => esc_html__('Activated', 'blaize'),
					'deactivated_btn' => esc_html__('Deactivated', 'blaize'),
				);
				wp_localize_script( 'welcome', 'welcomeObject', $localizes);
				wp_enqueue_style( 'welcome', get_template_directory_uri() . '/welcome/css/welcome.css' );
			}

			public function register_menu() {
				add_theme_page( esc_html__('Welcome', 'blaize'), esc_html__('Welcome', 'blaize'), 'edit_theme_options', 'welcome', array($this, 'welcome_screen') );
			}

			public function welcome_screen() {
				?>
				<h1><?php echo esc_html($this->theme_name). ' - ' . esc_html($this->theme_ver); ?></h1>
				<div class="wc-wrap">
					<div class="abt-theme">
						
					</div>
					<div class="wc-sections">

						<?php
							$section = isset( $_REQUEST['section'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['section'] ) ) : 'general_information';
						?>

						<?php if(!empty($this->tabs)) : ?>
							<div class="nav-tab-wrapper">
								<?php foreach($this->tabs as $id => $label) : ?>
									<?php
										$nav_class = 'nav-tab';
										if($id == $section) {
											$nav_class .= " nav-tab-active";
										}
									?>
									<a href="<?php echo esc_url(admin_url('themes.php?page=welcome&section='.$id)); ?>" class="<?php echo esc_attr($nav_class); ?>"><?php echo esc_html($label); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<?php if(!empty($this->tabs)) : ?>
							<div class="wc-section clearfix">
								<?php require_once get_template_directory() . '/welcome/sections/'.esc_html($section).'.php'; ?>
							</div>
						<?php endif; ?>
					</div>

				</div>
				<?php
			}

			public function call_plugin_api($plugin_slug) {
				include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

				$api = plugins_api( 'plugin_information', array(
					'slug' => $plugin_slug,
					'fields' => array(
						'downloaded'        => false,
						'rating'            => false,
						'description'       => false,
						'short_description' => true,
						'donate_link'       => false,
						'tags'              => false,
						'sections'          => true,
						'homepage'          => true,
						'added'             => false,
						'last_updated'      => false,
						'compatibility'     => false,
						'tested'            => false,
						'requires'          => false,
						'downloadlink'      => false,
						'icons'             => true
					)
				) );

				return $api;
			}

			/** Check For Icon **/
			public function check_for_icon( $arr ) {

				if ( ! empty( $arr['svg'] ) ) {
					$plugin_icon_url = $arr['svg'];
				} elseif ( ! empty( $arr['2x'] ) ) {
					$plugin_icon_url = $arr['2x'];
				} elseif ( ! empty( $arr['1x'] ) ) {
					$plugin_icon_url = $arr['1x'];
				} else {
					$plugin_icon_url = $arr['default'];
				}

				return $plugin_icon_url;
			}

			/** Check if Plugin is active or not **/
			public function get_plugin_status($plugin) {

				$folder_name = $plugin['slug'];
				$file_name = $plugin['filename'];
				$status = 'install';

				$path = WP_PLUGIN_DIR.'/'.esc_attr($folder_name).'/'.esc_attr($file_name);

				if(file_exists( $path )) {
					$status = class_exists($plugin['class']) ? 'deactive' : 'active';
				}

				return $status;

				return $status;
			}

			/** Generate Url for the Plugin Button **/
			public function generate_plugin_install_btn($status, $plugin) {

				$folder_name = $plugin['slug'];
				$file_name = $plugin['filename'];
				$url = $btn = '';

				switch ( $status ) {
					case 'install':
						return $btn = '<button class="install button" data-file="'.esc_attr($file_name).'" data-slug="'.esc_attr($folder_name).'">'.esc_html__('Install & Activate', 'blaize').'</button>';
						break;

					case 'deactive':
						return $btn = '<a class="deactivate button" data-file="'.esc_attr($file_name).'" data-slug="'.esc_attr($folder_name).'">'.esc_html__('Deactivate', 'blaize').'</a>';
						break;

					case 'active':
						return $btn = '<a class="activate button" data-file="'.esc_attr($file_name).'" data-slug="'.esc_attr($folder_name).'">'.esc_html__('Activate', 'blaize').'</a>';
						break;
				}
			}

			public function plugin_installer_callback() {
				//var_dump(current_user_can('install_plugins')); die();
				if ( ! current_user_can('install_plugins') ) {
					wp_die( esc_html__( 'Sorry, you are not allowed to install plugins on this site.', 'blaize' ) );
				}

				$nonce = isset( $_REQUEST["nonce"] ) ? sanitize_text_field( wp_unslash( $_REQUEST["nonce"] ) ) : '';
				$plugin = isset( $_REQUEST["plugin"] ) ? sanitize_text_field( wp_unslash( $_REQUEST["plugin"] ) ) : '';
				$plugin_file = isset( $_REQUEST["plugin_file"] ) ? sanitize_text_field( wp_unslash( $_REQUEST["plugin_file"] ) ) : '';

				// Check our nonce, if they don't match then bounce!
				if (! wp_verify_nonce( $nonce, 'plugin_installer_nonce' ))
					wp_die( esc_html__( 'Error - unable to verify nonce, please try again.', 'blaize') );

         		// Include required libs for installation
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
				require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

				// Get Plugin Info
				$api = $this->call_plugin_api($plugin);

				$skin     = new WP_Ajax_Upgrader_Skin();
				$upgrader = new Plugin_Upgrader( $skin );
				$upgrader->install($api->download_link);

				$plugin_file = ABSPATH . 'wp-content/plugins/'.esc_attr($plugin).'/'.esc_attr($plugin_file);

				if($api->name) {
					if($plugin_file){
						activate_plugin($plugin_file);
						echo "success";
						die();
					}
				}
				echo "fail";

				die();
			}

			public function plugin_activate_callback() {
				if ( ! current_user_can('install_plugins') )
					wp_die( esc_html__( 'Sorry, you are not allowed to install plugins on this site.', 'blaize' ) );

				$nonce = isset( $_REQUEST["nonce"] ) ? sanitize_text_field( wp_unslash( $_REQUEST["nonce"] ) ) : '';
				$plugin = isset( $_REQUEST["plugin"] ) ? sanitize_text_field( wp_unslash( $_REQUEST["plugin"] ) ) : '';
				$plugin_file = isset( $_REQUEST["plugin_file"] ) ? sanitize_text_field( wp_unslash( $_REQUEST["plugin_file"] ) ) : '';

				// Check our nonce, if they don't match then bounce!
				if (! wp_verify_nonce( $nonce, 'plugin_activator_nonce' ))
					wp_die( esc_html__( 'Error - unable to verify nonce, please try again.', 'blaize') );

				$plugin_file = ABSPATH . 'wp-content/plugins/'.esc_attr($plugin).'/'.esc_attr($plugin_file);

				if($plugin_file){
					activate_plugin($plugin_file);
					echo "success";
					die();
				}
				echo "fail";
				die();
			}

			public function plugin_deactivate_callback() {
				if ( ! current_user_can('install_plugins') )
					wp_die( esc_html__( 'Sorry, you are not allowed to install plugins on this site.', 'blaize' ) );

				$nonce = isset($_REQUEST["nonce"]) ? sanitize_text_field( wp_unslash( $_REQUEST["nonce"] ) ) : '';
				$plugin = isset($_REQUEST["plugin"]) ? sanitize_text_field( wp_unslash( $_REQUEST["plugin"] ) ) : '';
				$plugin_file = isset($_REQUEST["plugin_file"]) ? sanitize_text_field( wp_unslash( $_REQUEST["plugin_file"] ) ) : '';

				// Check our nonce, if they don't match then bounce!
				if (! wp_verify_nonce( $nonce, 'plugin_deactivator_nonce' ))
					wp_die( esc_html__( 'Error - unable to verify nonce, please try again.', 'blaize') );

				$plugin_file = ABSPATH . 'wp-content/plugins/'.esc_attr($plugin).'/'.esc_attr($plugin_file);

				if($plugin_file){
					deactivate_plugins($plugin_file);
					echo "success";
					die();
				}
				echo "fail";
				die();
			}
		}

		new Blaize_Welcome();
	}

	if( class_exists('SWFT_Demo_Import') ) :
		$pagli_demo = new SWFT_Demo_Import;

		$pagli_demo->demos = array(
	        'corporate-demo' => array(
	            'title' => __('Corporate Demo', 'blaize'),
	            'xml_file' => get_template_directory() . '/welcome/demos/corporate-demo/content.xml',
	            'customizer_file' => get_template_directory() . '/welcome/demos/corporate-demo/customizer_options.dat',
	            'widget_file' => get_template_directory() . '/welcome/demos/corporate-demo/widgets.wie',
	            'preview_image' => get_template_directory_uri() . '/welcome/demos/corporate-demo/preview.png',
	            'preview_link' => 'http://demo.paglithemes.com/pagli/',
	            'menu' => array(
	                'Main Menu' => 'main-menu',
	            ),
	            'home_page' => 'front-page',
	            'blog_page' => 'blogs',
	        ),
	    );
	endif;