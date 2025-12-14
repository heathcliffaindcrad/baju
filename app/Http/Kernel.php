protected $routeMiddleware = [
    // ... middleware lainnya
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];