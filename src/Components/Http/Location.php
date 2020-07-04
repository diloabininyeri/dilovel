<?php


namespace App\Components\Http;

/**
 * Class Location
 * @package App\Components\Http
 */
class Location
{
    /**
     * @var array|mixed
     */
    private array  $locationInfo;

    public function __construct(string $ipAddress)
    {
        $response = (new Http())->get("http://www.geoplugin.net/json.gp?ip=$ipAddress");
        $this->locationInfo = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $key
     * @return string|null
     */
    private function getValueLocation(string $key): ?string
    {
        return $this->locationInfo[$key] ?? null;
    }

    /**
     * @return array
     */
    public function detail(): array
    {
        return $this->locationInfo;
    }

    /**
     * @return string|null
     */
    public function country(): ?string
    {
        return $this->getValueLocation('geoplugin_countryName');
    }

    /**
     * @return string|null
     */
    public function countryCode(): ?string
    {
        return $this->getValueLocation('geoplugin_countryCode');
    }

    /**
     * @return string|null
     */
    public function currencyCode(): ?string
    {
        return $this->getValueLocation('geoplugin_currencyCode');
    }

    /**
     * @return string|null
     */
    public function region(): ?string
    {
        return $this->getValueLocation('geoplugin_region');
    }

    /**
     * @return string|null
     */
    public function regionCode():?string
    {
        return $this->getValueLocation('geoplugin_regionCode');
    }

    /**
     * @return string|null
     */
    public function continentName():?string
    {
        return  $this->getValueLocation('geoplugin_continentName');
    }

    /**
     * @return string|null
     */
    public function latitude():?string
    {
        return $this->getValueLocation('geoplugin_latitude');
    }

    /**
     * @return string|null
     */
    public function longitude():?string
    {
        return $this->getValueLocation('geoplugin_longitude');
    }

    /**
     * @return string|null
     */
    public function timezone():?string
    {
        return $this->getValueLocation('geoplugin_timezone');
    }
    /**
     * @return string|null
     */
    public function city(): ?string
    {
        return $this->getValueLocation('geoplugin_regionName');
    }
}
