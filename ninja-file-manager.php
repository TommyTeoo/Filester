<?php
/**
 * Plugin Name: File Manager Pro
 * Plugin URI: https://ninjateam.org/wordpress-file-manager-pro
 * Description: Made to help you focus on WordPress file management and avoid being distracted.
 * Version: 1.0
 * Author: Ninja Team
 * Author URI: https://ninjateam.org
 * Text Domain: big-ninja
 * Domain Path: /i18n/languages/
 *
 * @package BigPlugin
 */

namespace NinjaFileManager;

if (file_exists(dirname(__FILE__) . '/includes/File_manager/lib/php/autoload.php')) {
  require_once dirname(__FILE__) . '/includes/File_manager/lib/php/autoload.php';
}

if (file_exists(dirname(__FILE__) . '/includes/File_manager/FMSyntaxChecker.php')) {
  require_once dirname(__FILE__) . '/includes/File_manager/FMSyntaxChecker.php';
}

if (file_exists(dirname(__FILE__) . '/includes/File_manager/FMMimeTypes.php')) {
  require_once dirname(__FILE__) . '/includes/File_manager/FMMimeTypes.php';
}

defined('ABSPATH') || exit;

define('NJT_FM_BN_PREFIX', 'njt-fm');
define('NJT_FM_BN_VERSION', '1.0');
define('NJT_FM_BN_DOMAIN', 'njt-fm');

define('NJT_FM_BN_PLUGIN_DIR', basename(__DIR__));
define('NJT_FM_BN_PLUGIN_URL', plugin_dir_url(__FILE__));
define('NJT_FM_BN_PLUGIN_PATH', plugin_dir_path(__FILE__));

spl_autoload_register(function ($class) {
  $prefix = __NAMESPACE__; // project-specific namespace prefix
  $base_dir = __DIR__ . '/includes'; // base directory for the namespace prefix

  $len = strlen($prefix);
  if (strncmp($prefix, $class, $len) !== 0) { // does the class use the namespace prefix?
    return; // no, move to the next registered autoloader
  }

  $relative_class_name = substr($class, $len);

  // replace the namespace prefix with the base directory, replace namespace
  // separators with directory separators in the relative class name, append
  // with .php
  $file = $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';

  if (file_exists($file)) {
    require $file;
  }
});

function init() {
  Plugin::getInstance();
  I18n::getInstance();
  File_manager\FileManager::getInstance();
}
add_action('plugins_loaded', 'NinjaFileManager\\init');

register_activation_hook(__FILE__, array('NinjaFileManager\\Plugin', 'activate'));
register_deactivation_hook(__FILE__, array('NinjaFileManager\\Plugin', 'deactivate'));