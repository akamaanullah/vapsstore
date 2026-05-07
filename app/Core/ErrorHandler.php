<?php
namespace App\Core;

use Throwable;

class ErrorHandler {
    public static function register() {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleFatalError']);
    }

    public static function handleException(Throwable $exception) {
        self::logError($exception);
        self::renderErrorPage($exception->getCode(), $exception->getMessage(), $exception);
    }

    public static function handleError($level, $message, $file, $line) {
        if (error_reporting() & $level) {
            $exception = new \ErrorException($message, 0, $level, $file, $line);
            self::handleException($exception);
        }
    }

    public static function handleFatalError() {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $exception = new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
            self::handleException($exception);
        }
    }

    private static function logError(Throwable $exception) {
        $logFile = dirname(__DIR__, 2) . '/scratch/logs/error.log';
        if (!is_dir(dirname($logFile))) {
            mkdir(dirname($logFile), 0777, true);
        }

        $message = sprintf(
            "[%s] %s: %s in %s on line %d\nStack trace:\n%s\n",
            date('Y-m-d H:i:s'),
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        error_log($message, 3, $logFile);
    }

    private static function renderErrorPage($code, $message, $exception = null) {
        $code = ($code >= 400 && $code < 600) ? $code : 500;
        http_response_code($code);

        // Check if we are in development mode (should be in .env)
        $debug = getenv('APP_DEBUG') === 'true';

        if (PHP_SAPI === 'cli') {
            echo "Error ($code): $message\n";
            return;
        }

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error <?= $code ?></title>
            <style>
                body { font-family: sans-serif; text-align: center; padding: 50px; background: #f4f4f4; color: #333; }
                .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                h1 { color: #e74c3c; }
                pre { text-align: left; background: #eee; padding: 15px; overflow: auto; border-radius: 4px; font-size: 13px; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Oops! Something went wrong.</h1>
                <p>Error Code: <?= $code ?></p>
                <p><?= $debug ? htmlspecialchars($message) : "A server error occurred. Please try again later." ?></p>
                <?php if ($debug && $exception): ?>
                    <pre><?= htmlspecialchars($exception->getTraceAsString()) ?></pre>
                <?php endif; ?>
                <a href="/">Go to Home</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}
