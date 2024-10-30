<?php
/*
 * Plugin Name: Link To Bible
 * Description: Automatically links bible references in posts to the appropriate bible verse(s) at bibleserver.com
 * Version: 3.0.3
 * Plugin URI: https://wordpress.org/extend/plugins/link-to-bible/
 * Author: erfonlinedev
 * Author URI: https://www.bibleserver.com/webmasters
 * Donate link: https://www.bibleserver.com/donate
 * Requires PHP: 5.6
 * Min WP Version: 5.2
 * Max WP Version: 6.6.1
 * Text Domain: link-to-bible
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/copyleft/gpl.html
 */

/*
 * License: GPLv3, see 'license.txt'
 * Published with the explicit approval of bibleserver.com / ERF Medien e.V. (06.12.2011)
 */

use LTB\Config;
use LTB\Plugin;

require_once 'autoload.php';

Config::create('3.0.0','Link To Bible','ltb');

// Load translations
load_plugin_textdomain('ltb', false, basename(dirname(__FILE__)) . '/languages');

// show admin notice, if no api-key is set
register_activation_hook(__FILE__, [Plugin::class, 'register']);

foreach (Plugin::getAllFilters() as $filter) {
	add_filter($filter->getHook(), $filter->getCallable(), $filter->getPriority(), $filter->getAcceptedArgs());
}

foreach (Plugin::getActions() as $action) {
	add_action($action->getHook(), $action->getCallable());
}
