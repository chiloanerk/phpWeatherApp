<?php

global $router;
$router->addRoute('GET', '/', 'home/index');
$router->addRoute('GET', '/test', 'home/test');