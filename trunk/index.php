<?php
/**
 * $Id$
 * @package IndigoPen
 *
 * @todo    Do we need to flush the buffer to stop it hanging sometimes
 *          (particularly RPC)?
 */

/**
 */
define('INDIGOPEN', '0.01.000');

// turn off error handling until we have got everything configured.
error_reporting(E_ALL);
ini_set('display_errors', false);
 ini_set('display_errors', true); // uncomment this to show errors in config.php

// load the config files
$conf = array();
$conf['timer']      = microtime();
$conf['base_path']  = dirname(__FILE__);

// include($conf['base_path'] . '/config_default.php');
require($conf['base_path'] . '/_local/config.php');

if ( empty($conf['installed']) ) {
  ini_set('display_errors', true); // without this it is difficult to debug installation!
  require($conf['base_path'] . '/modules/install/index.php');
  return;
}

// now we have $conf we can set up proper error handling
require_once($conf['base_path'] . '/modules/error/error_handling.php');

require_once($conf['base_path'] . '/modules/core/core.php');
$ipen =& indigo_pen::get_ipen($conf);

$ipen->dispatch();

if ( $conf['debug'] ) {
  // prevent the output buffer handler thinking it is an error
  ipen_fatal_error_trap(false);
}

// end
