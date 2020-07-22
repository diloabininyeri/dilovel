<?php


namespace App\Components\Route;

/**
 * Class GenerateRouter
 * @package App\Components\Route
 */
class GenerateRoute
{
    /**
     * @var string
     */
    private string $url;

    /**
     * GenerateRouter constructor.
     * @param string $routerName
     * @param array $parameters
     */
    public function __construct(string $routerName, array $parameters=[])
    {
        $this->url($routerName, $parameters);
    }

    /**
     * @param string|null $hash
     * @return $this
     */
    public function withHash(string $hash): self
    {
        $this->url.= '#' . $hash;
        return $this;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function withQuery(array $query):self
    {
        $this->url .= '?' . http_build_query($query);
        return $this;
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     */
    private function url(string $name, array $parameters = []): string
    {
        $routeUrl = RouterName::getName($name)['router_url'];
        if (!empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $routeUrl = str_replace($key, $value, $routeUrl);
            }
        }

        return $this->url=url()->base().'/'.$routeUrl;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->url;
    }
}
