<?php

/*
Plugin Name: Flags Widget
Plugin URI: http://www.ab-weblog.com/en/wordpress-plug-ins/flags-widget/
Description: A simple plug-in that displays flag icons that link to other language versions of your blog.
Version: 1.0.3
Author: Andreas Breitschopp
Author URI: http://www.ab-weblog.com
*/

/*
Copyright 2011 by Andreas Breitschopp (e-mail: a-breitschopp@ab-tools.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined ('FW_DEF_STRING')) define('FW_DEF_STRING', 'fw');

if (!defined ('FW_PLUGIN_PATH'))  
  define ('FW_PLUGIN_PATH', plugin_basename(__FILE__));

load_plugin_textdomain(FW_DEF_STRING, false, dirname(FW_PLUGIN_PATH) . '/languages/');
wp_enqueue_style('flags-widget', plugin_dir_url(FW_PLUGIN_PATH) . 'css/flags-widget.css');
wp_enqueue_script('flags-widget', plugin_dir_url(FW_PLUGIN_PATH) . 'js/flags-widget.js');

require_once (dirname(__FILE__) . '/includes/FWCommon.php');
require_once (dirname(__FILE__) . '/includes/FWWidget.php');
require_once (dirname(__FILE__) . '/includes/FWOutput.php');

if (is_admin())
  require_once (dirname(__FILE__) . '/includes/FWAdmin.php');
?>