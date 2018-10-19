<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Api View.
$container['view'] = function ($c) {
    // Simple Content Negotiation (json and xml).
    $defaultMediaType = 'application/json';
    $outputParam = 'output';
    $checkHeader = true;
    return new \App\Renders\ApiView($defaultMediaType, $outputParam, $checkHeader);
};

// Database.
$container['db'] = function($c) {
    $cfg = $c->get('settings')['db'];
    $t = "testing";
    $driver = $cfg['driver'];
    $host = $cfg['host'];
    $port = $cfg['port'];
    $database = $cfg['database'];
    $user = $cfg['username'];
    $password = $cfg['password'];
    $charset = $cfg['charset'];
    $debug = $c->get('settings')['debug'];
    $dsn = isset($port)
        ? "{$driver}:host={$host};port={$port};dbname={$database};charset={$charset}"
        : "{$driver}:host={$host};dbname={$database};charset={$charset}";

    try {
        $pdo = new \PDO($dsn, $user, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // If you want to use a Repository.
        //$apiRepo = new \App\Db\ApiRepository($pdo, $debug);
        //$apiRepo->appRouter = $c->get('router');
        //return $apiRepo;
        return $pdo;
    } catch (\PDOException $e) {
        throw $e;
    }
};

// -----------------------------------------------------------------------------
// Helpers
// -----------------------------------------------------------------------------


// Session Helper
$container['session'] = function($c){
    // session_start();
    return new \SlimSession\Helper;
};

// PasswordHasher Helper
$container['phash'] = function($c){
    return new \App\Helpers\PasswordHasher();
};


// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// Monolog.
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);

    $formatter = new \Monolog\Formatter\LineFormatter(
        "[%datetime%] [%level_name%]: %message% %context%\n",
        null,
        true,
        true
    );
    /* Log to timestamped files */
    $rotating = new \Monolog\Handler\RotatingFileHandler($settings['logger']['path'], 0, \Monolog\Logger::DEBUG);
    $rotating->setFormatter($formatter);
    $logger->pushHandler($rotating);

    return $logger;
};

// -----------------------------------------------------------------------------
// Error Handlers
// -----------------------------------------------------------------------------

// Override the default Error Handler. To trap PHP Exceptions.
$container['errorHandler'] = function ($c) {
    return new \App\Handlers\ApiError($c['view'], $c['logger'], $c->get('settings')['displayErrorDetails']);
};

// Override the default error handler for PHP 7+ Throwables.
$container['phpErrorHandler'] = function ($c) {
    return new \App\Handlers\ApiPhpError($c['view'], $c['logger'], $c->get('settings')['displayErrorDetails']);
};

// Override the default 404 Not Found Handler.
$container['notFoundHandler'] = function ($c) {
    return new \App\Handlers\ApiNotFound($c['view']);
};

// Override the default 405 Not Allowed Handler
$container['notAllowedHandler'] = function ($c) {
    return new \App\Handlers\ApiNotAllowed($c['view']);
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------
$container[App\Controllers\ExampleAction::class] = function ($c) {
    return new App\Controllers\ExampleAction($c->get('view'), $c->get('logger'));
};

$container[App\Controllers\TestingController::class] = function ($c) {
    return new App\Controllers\TestingController($c->get('view'), $c->get('logger'), $c->get('db'));
};

$container[App\Controllers\AdminAuthController::class] = function ($c) {
    return new App\Controllers\AdminAuthController(
        $c->get('view'), 
        $c->get('logger'), 
        $c->get('db'), 
        $c->get('session'),
        $c->get('phash')
    );
};

$container[App\Controllers\CustomersController::class] = function($c){
    return new App\Controllers\CustomersController(
        $c->get('view'),
        $c->get('logger'),
        $c->get('db')
    );
};