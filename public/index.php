<?php
// echo password_hash("admin", PASSWORD_DEFAULT);
require_once "../src/vendor/autoload.php";
require_once "../src/config/config.php";
use src\core\App;


$app = new App();
echo $app->run();
