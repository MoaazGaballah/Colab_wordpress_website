<?php
	if(class_exists('SWFT_Demo_Import')) :

		do_action( 'swift_demo_import' );

	else :
		$plugin = array(
			'slug' => 'swift-demo-import',
			'filename' => 'swift-demo-import.php'
		);
		$info = $this->call_plugin_api('swift-demo-import');
		$icon_url = $this->check_for_icon($info->icons);
		$plugin_status = $this->get_plugin_status( $plugin );
		$btn_url = $this->generate_plugin_install_btn($plugin_status, $plugin);

		?>
		<div class="install-plugin-notice postbox">
			<h2><?php esc_html_e( 'Install Swift Demo Import', 'blaize' ); ?></h2>
			<p><?php esc_html_e( 'The plugin allows you to install the demo in one click.', 'blaize' ); ?></p>

			<div class="btn-wrapper">
				<?php echo $btn_url; ?>
			</div>
		</div>
		<?php

	endif;