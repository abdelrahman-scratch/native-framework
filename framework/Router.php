<?php

namespace Framework;

use Psr\Log\LoggerInterface;

class Router
{
    /**
     * @var array
     */
    private $routes;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RequestInterface $request, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->request = $request;
        if (in_array($this->request->getMethod(), ["POST", "PUT", "DELETE"]) && !CSRFToken::check(Input::get(Constant::CSRF_TOKEN))) {
            $this->logger->error('CSRF token is not valid');
            Redirect::backWithErrors(['The form has expired due to inactivity. Please try again']);
        }
        $this->routes = [];

    }

    /**
     * @param string $httpMethod
     * @param string $route
     * @param string $functionPath
     */
    public function addRoute(string $httpMethod, string $route, string $functionPath)
    {
        $handler = $this->getHandler($functionPath);
        $this->routes[] = [
            "method" => $httpMethod,
            "uri" => '/' . $route,
            "handler" => $handler
        ];
    }

    /**
     * @param $functionPath
     * @return array
     */
    protected function getHandler($functionPath): array
    {
        $path = explode("@", $functionPath);

        $controller = $path[0];
        $method = $path[1];

        $className = Constant::APP_CONTROLLERS_PATH . $controller;

        return [$className, $method];
    }

    public function run()
    {

        $method = $this->request->getMethod();

        foreach ($this->routes as $route) {
            $isUrlMatched = $this->isUriMatched($route["uri"]);
            if ($route["method"] == $method && $isUrlMatched) {
                $className = $route["handler"][0];
                $method = $route["handler"][1];
                $params = $this->getAllParameters($route["uri"]);
                $this->dispatch($className, $method, $params);
                return;
            }
        }
        $this->notFoundUri();
        return;
    }

    /**
     * @param string $className
     * @param string $method
     * @param array $params
     */
    protected function dispatch(string $className, string $method, array $params)
    {
        $object = new $className;
        echo $object->$method(...array_values($params));
    }

    /**
     * @param string $existedUri
     * @return bool
     */
    public function isUriMatched(string $existedUri): bool
    {
        $currentUri = $this->request->getUriPath();
        if ($existedUri == $currentUri) {
            return true;
        }


        //if number of url parts not equal
        if (count(explode("/", $existedUri)) != count(explode("/", $currentUri))) {
            return false;
        }

        $regex = $this->generateRegex($existedUri);

        if (preg_match($regex, $currentUri)) {
            return true;
        }
        return false;
    }

    /**
     * @param $route
     * @return string
     */
    protected function generateRegex($route)
    {
        $regex = preg_replace("@\{.*?\}@", ".*?", $route);
        return "!^{$regex}$!";
    }

    /**
     * @param string $existedUri
     * @return array
     */
    public function getAllParameters(string $existedUri)
    {
        $currentUri = $this->request->getUriPath();

        $currentUriParts = explode("/", $currentUri);
        $existedUriParts = explode("/", $existedUri);
        $params = array_diff($currentUriParts, $existedUriParts);

        return array_merge($params, $this->request->getQueryParams());
    }

    //@todo better handling for wrong uri's
    public function notFoundUri()
    {
        echo "404-Not found";
    }


}