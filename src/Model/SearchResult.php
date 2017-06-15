<?php

namespace Model;


class SearchResult
{
    private $restaurantId;

    private $price;

    /**
     * SearchResult constructor.
     * @param $restaurantId
     * @param $price
     */
    public function __construct($restaurantId, $price)
    {
        $this->restaurantId = (int) $restaurantId;
        $this->price = (float) $price;
    }

    /**
     * @return int
     */
    public function getRestaurantId()
    {
        return $this->restaurantId;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}