<?php


namespace App\Components\Routers;

/**
 * Class GenerateRouter
 * @package App\Components\Routers
 */
class GenerateRouter
{
    private ?string $hash = null;

    /**
     * @param string|null $hash
     * @return $this
     */
    public function withHash(?string $hash): self
    {
        if ($hash) {
            $this->hash = '#' . $hash;
        }
        return $this;
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function url(string $name, array $parameters = []): string
    {
        $routeUrl = RouterName::getName($name)['router_url'];
        if (!empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $routeUrl = str_replace($key, $value, $routeUrl);
            }
        }
        if (!$this->hash) {
            return url()->base() . '/' . $routeUrl;
        }
        return url()->base() . '/' . $routeUrl . $this->hash;
    }
}
