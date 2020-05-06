<div class="theme-introduction postbox">
	<h2><?php esc_html_e( 'Introduction', 'blaize' ); ?></h2>
	<p>
	<?php esc_html_e( 'Blaize is an elegant, responsive WordPress theme. The theme is perfect for marketing, corporate startup, agency, blog, business, company, creative, portfolio, ecommerce, professional business, food & restaurant websites. The multiple home section layouts and dynamic color options allows you to create a different looking websites using the same theme. The theme is translation ready, fully SEO optimized, fast loading and compatible with all trending WordPress page builder plugins', 'blaize' ); ?>
	</p>

	<h2><?php esc_html_e( 'How to Install Demo', 'blaize' ); ?></h2>
	<p>
		<ol>
			<li><?php /* translators: %s : recommended plugins tab link */ printf( wp_kses( __( 'Make sure you\'ve successfully installed all the plugins under <a href="%s">Recommended Plugins</a> tabs.', 'blaize'), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'themes.php?page=welcome&section=plugins_required' ) ) ); ?></li>
			<li><?php /* translators: %s : Import Demo tab link */ printf( wp_kses( __( 'Then Go to <a href="%s">Import Demo</a> tab and install the <strong>Swift Demo Import</strong> plugin.', 'blaize' ), array( 'a' => array( 'href' => array() ), 'strong' => array() ) ), esc_url( admin_url( 'themes.php?page=welcome&section=import_demo' ) ) ); ?></li>
			<li><?php esc_html_e( 'Now, Install the Demo.', 'blaize' ); ?></li>
		</ol>
	</p>
</div>

<div class="theme-detail row clearfix">
	<div class="theme-guide postbox">
		<h3><?php esc_html_e( 'Theme Guide', 'blaize' ); ?></h3>
		<p><?php esc_html_e( 'Having trouble in using the theme ? Follow our clear and staright forward documentation to configure the site. We have prepared documentation keeping even the novice users in mind. It provides the step by step process on using the options.', 'blaize' ); ?></p>
		<a class="button button-primary" href="<?php echo esc_url('http://doc.paglithemes.com/blaize/'); ?>"><?php esc_html_e( 'Read Documentation', 'blaize' ); ?></a>
	</div>

	<div class="chat-n-support postbox">
		<h3><?php esc_html_e( 'Support', 'blaize' ); ?></h3>
		<p><?php esc_html_e( 'Lost while following the documentation and configuring the site ? Find a bug within the theme ? Please reach us via online chat or email us about it. We will get to you as soon as possible.', 'blaize' ); ?></p>
		<a class="button button-primary" href="<?php echo esc_attr('mailto:support@paglithemes.com'); ?>"><?php esc_html_e( 'Email Us', 'blaize' ); ?></a>
	</div>
</div>