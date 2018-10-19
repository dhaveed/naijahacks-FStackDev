<?php
define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';


// Load "Environments" files.
if (file_exists(BASE_PATH . '/env.php')) {
    $envSettings = \Noodlehaus\Config::load(BASE_PATH . '/env.php');
} else {
    $envSettings = \Noodlehaus\Config::load(BASE_PATH . '/env.php.dist');
}

// Timezone.
date_default_timezone_set($envSettings->get('TIMEZONE', 'UTC'));
// Encoding.
mb_internal_encoding('UTF-8');

// Instantiate the app.
$settings = require BASE_PATH . '/config/settings.php';
$app = new \Slim\App($settings);
// Session
$app->add(new \Slim\Middleware\Session([
    'name' => 'emSession',
    'autorefresh' => true,
    'lifetime' => '1 hour'
]));

$dbhandler = require __DIR__ . '/../dbhandler/util/functions.php';
// Set up dependencies.
require BASE_PATH . '/config/dependencies.php';

// Register middleware.
require BASE_PATH . '/config/middleware.php';

// Register routes.
require BASE_PATH . '/routes/routes.php';

// Run!
$app->run();


function verifyRequiredParams($in, $required){
    $faultyFields = ""; $hasFault = false;
    foreach($required as $param){
        if(!isset($in[$param]) || strlen(trim($in[$param])) <= 0){
            $hasFault = true;
            $faultyFields .= $param . ", ";
        }
    }

    if($hasFault){
        $errorMessage = "The following required field(s) is either missing or empty: " . $faultyFields;
        return ['e' => $hasFault, "m" => $errorMessage];
    }

    return ["e" => $hasFault];
}
