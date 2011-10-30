<?php
class Flags_Widget extends WP_Widget {
	/** constructor */
	function Flags_Widget() {
		parent::WP_Widget(false, $name = 'Flags_Widget');
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract($args);
    $countryflaglist = get_option('fw_country_flag_list');
    $error = false;
    if ($countryflaglist) {
      if (count($countryflaglist) > 0) {
        $cssstyleall = get_option('fw_cssstyleall');
        $cssstyleflag = get_option('fw_cssstyleflag');
        ?>
          <div class="flag-icons-outer" style="<?php echo $cssstyleall; ?>">
            <div class="flag-icons-inner" style="left:<?php echo $instance['flags_position_left']; ?>px;top:<?php echo $instance['flags_position_top']; ?>px;">
              <?php
                foreach ($countryflaglist as $country) {
                  if ($instance['flag_title_' . $country] == '') {
                    $countrylist = fw_get_countrylist();
                    $instance['flag_title_' . $country] = $countrylist[$country];
                  }
                  if ($instance['flag_icon_' . $country] == '') {
                    $pluginurl = parse_url(plugin_dir_url(FW_PLUGIN_PATH));
                    $instance['flag_icon_' . $country] = $pluginurl['path'] . 'flags/' . $country . '.png';
                  }
                  if ($instance['flag_target_' . $country] == '')
                    $instance['flag_target_' . $country] = '/' . strtolower($country) . '/';

                  if ($cssstyleflag != '')
                    print('<div style="' . $cssstyleflag . '">');

                  $iconurl = $instance['flag_icon_' . $country];
                  if (substr($iconurl, 0, 4) != 'http') {
                    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                      $protocol = 'https';
                    else
                      $protocol = 'http';
                    $iconurl = $protocol . '://' . $_SERVER["SERVER_NAME"] . $iconurl;
                  }
                  $imagesize = getimagesize($iconurl);
                  if ($imagesize) $imagesize = $imagesize[3];

                  print('<a href="' . esc_attr($instance['flag_target_' . $country]) . '"><img src="' . esc_attr($instance['flag_icon_' . $country]). '" ' . $imagesize . ' title="' . esc_attr($instance['flag_title_' . $country]) . '" alt="' . esc_attr($instance['flag_title_' . $country]) . '" /></a>');

                  if ($cssstyleflag != '')
                    print('</div>');
                  else
                    print(' ');
                }
              ?>
            </div>
          </div>
        <?php
      } else $error = true;
    } else $error = true;
    if ($error) {
      print('<p><strong>' .
        __('You have to add country flags in the plug-in settings before showing this widget!', FW_DEF_STRING) .
        '</strong></p>'
      );
    }
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
    foreach ($new_instance as $key => $value) {
      $instance[$key] = $value;
    }
		if (!is_numeric($instance['flags_position_left'])) $instance['flags_position_left'] = '0';
		if (!is_numeric($instance['flags_position_top'])) $instance['flags_position_top'] = '0';
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
    $countryflaglist = get_option('fw_country_flag_list');
    $error = false;
    if ($countryflaglist) {
      if (count($countryflaglist) > 0) {
        $countrylist = fw_get_countrylist();
        $flags_position_left = esc_attr($instance['flags_position_left']);
        $flags_position_top = esc_attr($instance['flags_position_top']);
        ?>
          <p>
            <label for="<?php echo $this->get_field_id('flags_position_left'); ?>"><?php _e('Flags position offset (left):', FW_DEF_STRING); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('flags_position_left'); ?>"
              name="<?php echo $this->get_field_name('flags_position_left'); ?>" type="text" value="<?php echo $flags_position_left; ?>" />
            <label for="<?php echo $this->get_field_id('flags_position_top'); ?>"><?php _e('Flags position offset (top):', FW_DEF_STRING); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('flags_position_top'); ?>"
              name="<?php echo $this->get_field_name('flags_position_top'); ?>" type="text" value="<?php echo $flags_position_top; ?>" />
            <p><em><?php _e('Play with these values above to place the flags correctly depending on your theme.', FW_DEF_STRING); ?></em></p>
            <?php
              foreach ($countryflaglist as $country) {
                if ($instance['flag_title_' . $country] == '')
                  $instance['flag_title_' . $country] = $countrylist[$country];
                if ($instance['flag_icon_' . $country] == '') {
                  $pluginurl = parse_url(plugin_dir_url(FW_PLUGIN_PATH));
                  $instance['flag_icon_' . $country] = $pluginurl['path'] . 'flags/' . $country . '.png';
                }
                if ($instance['flag_target_' . $country] == '')
                  $instance['flag_target_' . $country] = '/' . strtolower($country) . '/';
                ?>
                <fieldset style="border:1px solid #C0C0C0;">
                  <legend style="margin-left:10px;"><?php echo $countrylist[$country]; ?></legend>
                  <div style="margin:5px;">
                      <label for="<?php echo $this->get_field_id('flag_title_' . $country); ?>"><?php _e('Flag icon title/alt:', FW_DEF_STRING); ?></label> 
                      <input class="widefat" id="<?php echo $this->get_field_id('flag_title_' . $country); ?>"
                        name="<?php echo $this->get_field_name('flag_title_' . $country); ?>" type="text" value="<?php echo esc_attr($instance['flag_title_' . $country]); ?>" />
                      <label for="<?php echo $this->get_field_id('flag_icon_' . $country); ?>"><?php _e('Flag icon image URL:', FW_DEF_STRING); ?></label> 
                      <input class="widefat" id="<?php echo $this->get_field_id('flag_icon_' . $country); ?>"
                        name="<?php echo $this->get_field_name('flag_icon_' . $country); ?>" type="text" value="<?php echo esc_attr($instance['flag_icon_' . $country]); ?>" />
                      <label for="<?php echo $this->get_field_id('flag_target_' . $country); ?>"><?php _e('Flag icon target URL:', FW_DEF_STRING); ?></label> 
                      <input class="widefat" id="<?php echo $this->get_field_id('flag_target_' . $country); ?>"
                        name="<?php echo $this->get_field_name('flag_target_' . $country); ?>" type="text" value="<?php echo esc_attr($instance['flag_target_' . $country]); ?>" />
                  </div>
                </fieldset>
                <?php
              }
            ?>
          </p>
        <?php
      } else $error = true;
    } else $error = true;
    if ($error) {
      print('<p><strong>' .
        sprintf(
          __('You have to add country flags in the %splug-in settings%s before showing this widget!', FW_DEF_STRING),
          '<a href="options-general.php?page=flags-widget-options">',
          '</a>'
          ) .
        '</strong></p>'
      );
    }
	}
} // class Flags_Widget
add_action('widgets_init', create_function('', 'return register_widget("Flags_Widget");'));
?>