<?php


namespace App\Components\Http\Response;

use App\Components\Route\Redirect\Redirect;
use JsonException;

/**
 * Class Response
 * @package App\Components\Http\Response
 */
class Response
{
    /**
     * @var int $status
     */
    private int $status = 200;

    /**
     * @var string $charset
     */
    private string  $charset = 'utf-8';

    private ?string $header=null;

    /***
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

    public static function toImage(): ResponseImage
    {
        return new ResponseImage();
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

    public static function redirect(): Redirect
    {
        return new Redirect();
    }

    /**
     * @param string $header
     * @return Response
     */
    public function setHeader(string $header): Response
    {
        $this->header = header("Content-Type: $header");
        return $this;
    }
}
