<?php

use fw\Router;

Router::add('^exercise/(?P<alias>[\w]+)?$', ['controller' => 'exercise', 'action' => 'view']);
Router::add('^exercises/(?P<alias>[\w]+)?$', ['controller' => 'exercises', 'action' => 'index']);

// default routes
Router::add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
