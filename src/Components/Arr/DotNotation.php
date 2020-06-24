<?php


namespace App\Components\Arr;

use App\Components\Traits\Singleton;

/**
 * Class DotNotation
 * @package App\Components\Arr
 */
class DotNotation
{
    use Singleton;

    /**
     * @param $key
     * @param array $data
     * @param null $default
     * @return array|mixed|null
     */
    public function getValueByKey(string $key, array $data, $default = null)
    {
        // @assert $key is a non-empty string
        // @assert $data is a loopable array
        // @otherwise return $default value
        if (!is_string($key) || empty($key) || !count($data)) {
            return $default;
        }

        // @assert $key contains a dot notated string
        if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);

            foreach ($keys as $innerKey) {
                // @assert $data[$innerKey] is available to continue
                // @otherwise return $default value
                if (!array_key_exists($innerKey, $data)) {
                    return $default;
                }

                $data = $data[$innerKey];
            }

            return $data;
        }

        // @fallback returning value of $key in $data or $default value
        return array_key_exists($key, $data) ? $data[$key] : $default;
    }
}
