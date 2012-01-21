<?php
define("BASEDIR",dirname(__FILE__).'/../');

require_once BASEDIR.'lib/slim/Slim.php';
require_once BASEDIR.'lib/sag/Sag.php';
require_once BASEDIR.'lib/facebook/facebook.php';
require_once BASEDIR.'lib/common.php';

session_start();
$app = new Slim();

require_once 'routes.php';

$app->run();

session_write_close();