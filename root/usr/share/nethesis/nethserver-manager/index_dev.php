<?php
/*
 * Copyright (C) 2011 Nethesis S.r.l.
 *
 * This script is part of NethServer.
 *
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

// PHP settings (timezone, error reporting..)
date_default_timezone_set('UTC');
error_reporting(E_ALL | E_STRICT);
ini_set('session.use_trans_sid', "0");
session_cache_limiter(FALSE);
ini_set('display_errors', "1");
ini_set('html_errors', "0");
ini_set('default_mimetype', 'text/plain');
ini_set('default_charset', 'UTF-8');

if(TRUE) {
  header('HTTP/1.1 403 Forbidden');
  echo "Access denied";
  exit;
}

// If xdebug is loaded, disable xdebug backtraces:
extension_loaded('xdebug') && xdebug_disable();

// Disable hashed target names:
define('NETHGUI_ENABLE_TARGET_HASH', FALSE);

// Enable nethgui javascript files auto inclusion:
define('NETHGUI_ENABLE_INCLUDE_WIDGET', TRUE);

// Enable caching:
define('NETHGUI_ENABLE_HTTP_CACHE_HEADERS', TRUE);

require_once('../Nethgui/Framework.php');

$FW = new \Nethgui\Framework();
$FW
    ->setLogLevel(E_WARNING | E_ERROR)
    ->registerNamespace(realpath(__DIR__ . '/../NethServer'))
    ->setDefaultModule('Status')
;

try {
    $FW->dispatch($FW->createRequest());
} catch (\Nethgui\Exception\HttpException $ex) {
    $FW->printHttpException($ex, TRUE);
}
