<?php
$start = microtime(true);

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS . '/functions.php';
require_once CONF . '/routes.php';

new \fw\App();

echo '<div class="page-footer grey darken-3 section"> <div class="container">Time: '.(microtime(true) - $start).' sec. </div></div>';