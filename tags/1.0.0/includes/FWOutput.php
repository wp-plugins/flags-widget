<?php
function fw_footer() {
	$supportplugin = get_option('fw_supportplugin');

	if ($supportplugin) {
		$locale = get_locale();
		if (substr($locale, 0, 2) == 'de') {
			$lang = 'de';
			$url = 'http://www.ab-weblog.com/de/wordpress-plug-ins/flaggen-widget/';
			$title = 'Flaggen-Widget';
		} else {
			$lang = 'en';
			$url = 'http://www.ab-weblog.com/de/wordpress-plug-ins/flags-widget/';
			$title = 'Flags Widget';
    }

		print('<p style="text-align:center;font-size:x-small;color:#808080;"><a style="font-weight:normal;color:#808080" href="' . $url . '" title="' . $title . '" target="_blank">' . $title . '</a> powered by <a style="font-weight:normal;color:#808080" href="http://www.ab-weblog.com/' . $lang . '/" title="Software Developer Blog" target="_blank">AB-WebLog.com</a>.</p>');
	}
}
add_action('wp_footer', 'fw_footer');

/**
 * Returns the output of this plug-in for using the social widgets in your code.
 * 
 * @return string
 */
function get_the_flags() {
	#return fw_content_filter('', true);
}

/**
 * Directly sends the output of this plug-in to the browser.
 * 
 * @return string
 */
function the_flags() {
	#echo get_the_social_widgets();
}
?>