<?php


namespace App\Components\Cart;

use App\Components\Database\Model;
use App\Components\Http\Session;
use JsonException;


class Cart
{
    private Session $session;
    private string $priceFieldName = 'price';
    private string $quantityFieldName = 'quantity';

    private string  $sessionPrefix = 'cart_sessions';

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param Model $model
     * @param int $quantity
     * @return Cart
     */
    public function add(Model $model, int $quantity = 1): Cart
    {
        return $this->addToCart($model, $quantity);
    }


    /**
     * @param Model $model
     * @param int $quantity
     * @return Cart
     * @throws JsonException
     */
    private function addToCart(Model $model, int $quantity = 1): Cart
    {
        $this->session->put(
            $this->sessionPrefix, $model->getPrimaryKeyValue(), array_merge($model->toArray(), ['quantity' => $quantity])
        );
        return $this;
    }

    public function get()
    {
        return $this->session->get($this->sessionPrefix) ?? [];
    }

    /**
     * @param string $priceFieldName
     * @return Cart
     */
    public function setPriceFieldName(string $priceFieldName): Cart
    {
        $this->priceFieldName = $priceFieldName;
        return $this;
    }

    /**
     * @param string $quantityFieldName
     * @return Cart
     */
    public function setQuantityFieldName(string $quantityFieldName): Cart
    {
        $this->quantityFieldName = $quantityFieldName;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuantityFieldName(): string
    {
        return $this->quantityFieldName;
    }

    /**
     * @return string
     */
    public function getPriceFieldName(): string
    {
        return $this->priceFieldName;
    }

    /**
     * @param string $priceField
     * @param string $quantityField
     * @return float
     */
    public function total(string $priceField = 'price', string $quantityField = 'quantity'): float
    {
        $total = 0;
        foreach ($this->get() as $item) {
            $total += $item[$priceField] * $item[$quantityField];
        }
        return $total;

    }


    public function delete(Model $model)
    {
        $this->session->deleteByIndex($this->sessionPrefix,$model->getPrimaryKeyValue());
        return  true;
    }

    public function deleteAll():bool
    {
        return $this->session->delete($this->sessionPrefix);
    }

}
