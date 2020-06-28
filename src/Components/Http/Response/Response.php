<?php


namespace App\Components\Http\Response;

use JsonException;

/**
 * Class Response
 * @package App\Components\Http\Response
 */
class Response
{
    private int $status = 200;

    private string  $charset='utf-8';
    /**
     *
     */
    private function setHeaderJson()
    {
        return header("Content-type: application/json; charset=$this->charset");
    }

    /**
     * @param $data
     * @return string|null
     * @throws JsonException
     */
    private function jsonEncode($data): ?string
    {
        return json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * @param $data
     * @return string|null
     */
    public function toJson($data): ?string
    {
        $this->setHeaderJson();
        http_response_code($this->status);
        try {
            if (is_object($data) && method_exists($data, 'toJson')) {
                return $data->toJson();
            }
            return $this->jsonEncode($data);
        } catch (JsonException $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param int $status
     * @return Response
     */
    public function setStatus(int $status): Response
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $charset
     * @return Response
     */
    public function setCharset(string $charset): Response
    {
        $this->charset = $charset;
        return $this;
    }
}
