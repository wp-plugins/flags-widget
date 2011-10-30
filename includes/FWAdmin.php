<?php
function fw_admin() {
  ?>  
  <div class="wrap">
  <?php
  echo "<h2>" . __( 'Flags Widget Options', FW_DEF_STRING) . "</h2>";

  if ($_POST['fw_hidden'] == 'flag_delete') {
    $countryflag = $_POST['fw_country_flag_list'];
    $countryflaglist = get_option('fw_country_flag_list');
    foreach ($countryflag as $delete) {
      $countryflaglist = fw_remove_item_by_value($countryflaglist, $delete, false);
    }
    update_option('fw_country_flag_list', $countryflaglist);
  } elseif ($_POST['fw_hidden'] == 'flag_add') {
    $countryflag = $_POST['fw_country_flag'];
    
    $countryflaglist = get_option('fw_country_flag_list');
    if (!in_array($countryflag, $countryflaglist)) {
      $countryflaglist[] = $countryflag;
      update_option('fw_country_flag_list', $countryflaglist);
    }
  } elseif ($_POST['fw_hidden'] == 'settings_save') {
    $cssstyleall = $_POST['fw_cssstyleall'];
    $cssstyleflag = $_POST['fw_cssstyleflag'];
    $supportplugin = $_POST['fw_supportplugin'];

    ?>  
    <div class="updated">
      <p>
    <?php  
      update_option('fw_cssstyleall', $cssstyleall);
      update_option('fw_cssstyleflag', $cssstyleflag);
      update_option('fw_supportplugin', $supportplugin);
      ?>
      <strong><?php _e('Options saved.', FW_DEF_STRING); ?></strong>
      </p>
    </div>
    <?php
  }

  ?>
  <p>
    <?php echo sprintf(__('If you like this plug-in, please <a href="%s">consider a donation</a> to keep it free. Thank you!', FW_DEF_STRING),
                        'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=a-breitschopp%40ab-tools.com&item_name=Donation%20for%20Flags%20Widget%20Plug-In&no_shipping=0&no_note=1&tax=0&currency_code=EUR&lc=CA&bn=PP%2dDonationsBF&charset=UTF%2d8'); ?>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="4UD8BXBDQ6YQE">
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
    </form>
  </p>
  <?php

  $countrylist = fw_get_countrylist();
  $countryflaglist = get_option('fw_country_flag_list');
  $cssstyleall = get_option('fw_cssstyleall');
  $cssstyleflag = get_option('fw_cssstyleflag');
  $supportplugin = get_option('fw_supportplugin');
  ?>
    <table>
      <tr>
        <td>
          <form name="fw_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="fw_hidden" value="flag_delete">
            <table>
              <tr>
                <td>
                  <?php    echo "<h4>" . __( 'Change Displayed Country Flags', FW_DEF_STRING) . "</h4>"; ?>
                  <em><?php _e('Current country flag list:', FW_DEF_STRING) ?></em>
                </td>
              </tr>
              <tr>
                <td>
                  <select name="fw_country_flag_list[]" multiple="multiple" style="height: 100px" onChange="fw_flag_change('fw_flag_list', this.value)">
                    <?php
                    foreach($countryflaglist as $short) {
                      ?>
                      <option value="<?php echo $short; ?>"><?php echo $countrylist[$short]; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <img name="fw_flag_list" src="<?php echo plugin_dir_url(FW_PLUGIN_PATH); ?>flags/UNSET.png" width="18" height="16" title="<?php _e('Flag', FW_DEF_STRING); ?>" alt="<?php _e('Flag', FW_DEF_STRING); ?>">
                </td>
                <td valign="bottom">
                  <input type="submit" name="Submit" value="<?php _e('Delete selected country flag(s)', FW_DEF_STRING) ?>" />
                </td>
              </tr>
            </table>
          </form>
        </td>
      </tr>
      <tr>
        <td>
          <form name="fw_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="fw_hidden" value="flag_add">
            <table>
              <tr>
                <td>
                  <em><?php _e('Add a new country flag to the list above:', FW_DEF_STRING) ?></em>
                </td>
              </tr>
              <tr>
                <td>
                  <select name="fw_country_flag" onChange="fw_flag_change('fw_flag', this.value)">
                    <?php
                    $firstcountry = 'UNSET';
                    foreach($countrylist as $short => $name) {
                      if ($firstcountry == 'UNSET') $firstcountry = $short;
                      ?>
                      <option value="<?php echo $short; ?>"<?php if ($country == $short) echo ' selected="selected"'; ?>><?php echo $name; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <img name="fw_flag" src="<?php echo plugin_dir_url(FW_PLUGIN_PATH); ?>flags/<?php echo $firstcountry; ?>.png" width="18" height="16" title="<?php _e('Flag', FW_DEF_STRING); ?>" alt="<?php _e('Flag', FW_DEF_STRING); ?>">
                </td>
                <td valign="bottom">
                  <input type="submit" name="Submit" value="<?php _e('Add country flag', FW_DEF_STRING) ?>" />
                </td>
              </tr>
            </table>
          </form>
        </td>
      </tr>
      <tr>
        <td>
          <hr />
        </td>
      </tr>
      <tr>
        <td>
          <form name="fw_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="fw_hidden" value="settings_save">
            <table>
                <tr>
                  <td>
                    <?php    echo "<h4>" . __( 'Other Settings', FW_DEF_STRING) . "</h4>"; ?>  
                  </td>
                </tr>
              <tr>
                <td><?php _e("Additional CSS styles applied to whole flags box:", FW_DEF_STRING); ?></td>
                <td><input type="text" name="fw_cssstyleall" value="<?php echo $cssstyleall; ?>" size="20"> <?php _e('(e. g. "margin-bottom:20px")', FW_DEF_STRING); ?></td>
              </tr>
              <tr>
                <td><?php _e("Additional CSS styles applied to every flag:", FW_DEF_STRING); ?></td>
                <td><input type="text" name="fw_cssstyleflag" value="<?php echo $cssstyleflag; ?>" size="20"> <?php _e('(e. g. "margin-right:10px")', FW_DEF_STRING); ?></td>
              </tr>
              <tr>
                <td colspan="2"><input type="checkbox" name="fw_supportplugin" value="1" checked> <?php _e("Support this free plug-in with a small powered by link at your page footer. Thank you!", FW_DEF_STRING); ?></td>
              </tr>
            </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save options', FW_DEF_STRING) ?>" />
            </p>
          </form>
        </td>
      </tr>
    </table>
  </div>
  <?php
}

function fw_remove_item_by_value($array, $val = '', $preserve_keys = true) {
	if (empty($array) || !is_array($array)) return false;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
}

function fw_admin_actions() {  
    add_options_page(
      'Flags Widget Options',
      'Flags Widget',
      'manage_options',
      'flags-widget-options',
      'fw_admin'
        );
}
add_action ('admin_menu', 'fw_admin_actions');

function fw_plugin_action_links($links, $file) 
{
  if ($file == FW_PLUGIN_PATH) {
    $settingslink = '<a href="options-general.php?page=flags-widget">' . __('Settings', FW_DEF_STRING) . '</a>';
    array_unshift($links, $settingslink);
  }

  return $links;
}
add_filter('plugin_action_links', 'fw_plugin_action_links', 10, 2);
?>
