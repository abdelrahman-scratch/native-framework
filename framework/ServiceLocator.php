<?php

namespace Framework;


use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class ServiceLocator
{

    /**
     * @return Router
     * @throws \Exception
     */
    public static function getRouterService(): Router
    {
        $logger = static::getLoggerService();
        return new Router(new Request(), $logger);
    }

    /**
     * @return LoggerInterface
     * @throws \Exception
     */
    public static function getLoggerService(): LoggerInterface
    {
        $stream = new StreamHandler(dirname(__DIR__) . '/app.log', Logger::DEBUG);
        $logger = new Logger('app_logger');
        $logger->pushHandler($stream);
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }


}