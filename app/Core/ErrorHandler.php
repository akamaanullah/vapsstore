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
        $logFile = dirname(__DIR__, 2) . '/storage/logs/error.log';
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

        $settings = \App\Helpers\UIHelper::getSettings();
        $img = function($key, $default) use ($settings) {
            $val = $settings[$key] ?? '';
            if (empty($val)) return BASE_URL . '/' . $default;
            return (strpos($val, 'http') === 0) ? $val : BASE_URL . '/' . $val;
        };

        require dirname(__DIR__, 2) . "/views/front/error.php";
        exit;
    }
}
