/** Welcome Javascripts **/
jQuery(document).ready(function ($) {
	/** Ajax Plugin Installation **/
	$(".wc-sections .install").on('click', function (e) {
		e.preventDefault();
		var el = $(this);

    	el.addClass('installing');
    	var plugin = $(el).attr('data-slug');
    	var plugin_file = $(el).attr('data-file');
    	var ajaxurl = welcomeObject.ajaxurl;

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'plugin_installer',
				plugin: plugin,
				plugin_file: plugin_file,
				nonce: welcomeObject.installer_nonce,
			},
			success: function(response) {
		   		if(response == 'success'){
			   		el.attr('class', 'installed button');
			   		el.html(welcomeObject.installed_btn);
		   		}

		   		el.removeClass('installing');
		   		location.reload();
			},
		});
	});

	/** Ajax Plugin Acivation **/
	$(".wc-sections .activate").on('click', function (e) {
		e.preventDefault();
		var el = $(this);

		is_loading = true;
    	el.addClass('installing');
    	var plugin = $(el).attr('data-slug');
    	var plugin_file = $(el).attr('data-file');
    	var ajaxurl = welcomeObject.ajaxurl;

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'plugin_activator',
				plugin: plugin,
				plugin_file: plugin_file,
				nonce: welcomeObject.activator_nonce,
			},
			success: function(response) {
		   		if(response == 'success'){
			   		el.attr('class', 'installed button');
			   		el.html(welcomeObject.installed_btn);
		   		}

		   		el.removeClass('installing');
		   		is_loading = false;
		   		location.reload();
			},
			error: function(xhr, status, error) {
		  		el.removeClass('installing');
		  		is_loading = false;
			}
		});
	});

	/** Ajax Plugin Deactivation **/
	$(".wc-sections .deactivate").on('click', function (e) {
		e.preventDefault();
		var el = $(this);

		is_loading = true;
    	el.addClass('installing');
    	var plugin = $(el).attr('data-slug');
    	var plugin_file = $(el).attr('data-file');
    	var ajaxurl = welcomeObject.ajaxurl;

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'plugin_deactivator',
				plugin: plugin,
				plugin_file: plugin_file,
				nonce: welcomeObject.deactivator_nonce,
			},
			success: function(response) {
		   		if(response == 'success'){
			   		el.attr('class', 'installed button');
			   		el.html(welcomeObject.deactivated_btn);
		   		}

		   		el.removeClass('installing');
		   		is_loading = false;
		   		location.reload();
			},
			error: function(xhr, status, error) {
		  		el.removeClass('installing');
		  		is_loading = false;
			}
		});
	});
});