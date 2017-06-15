<?php

use Model\Restaurant;

class Controller
{
    private $searchProducts = [];

    /** @var Restaurant[] */
    private $restaurants = [];

    /**
     * Controller constructor.
     * @param array $restorans
     */
    public function __construct(array $configs)
    {
        if (($handle = fopen($configs['fileCvPath'], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if(!isset($this->restaurants[$data[0]])) {
                    $this->restaurants[$data[0]] = Restaurant::restore($data);
                    continue;
                }
                $this->restaurants[$data[0]]->addItems($data);
            }

            fclose($handle);
        }

        if(empty($this->restaurants)) {
            throw new Error('Restaurant file is empty or not found');
        }
    }

    /**
     * @return Restaurant[]
     */
    public function getRestaurants()
    {
        return $this->restaurants;
    }

    /**
     * @param Restaurant[] $restaurants
     */
    public function setRestaurants($restaurants)
    {
        $this->restaurants = $restaurants;
    }

    public function prepareSearchProducts($products = []) {
        $this->searchProducts = [];
        foreach ($products as $product){
            if($product) {
                $this->searchProducts[] = $product;
            }
        }
    }

    /**
     * @param array $products
     * @return \Model\SearchResult|null
     */
    public function getOptimalRestaurant($products = []) {
        $resultCollection = $this->searchRestaurants($products);
        return !empty($resultCollection) ? reset($resultCollection) : null;

    }

    /**
     * @param array $products
     * @return \Model\SearchResult[]
     */
    private function searchRestaurants($products = []){
        $this->prepareSearchProducts($products);

        $restaurantResults = [];
        foreach ($this->restaurants as $restaurant) {
            if($restaurant->haveItems($this->searchProducts)) {
                $price = $restaurant->getPriceItems($this->searchProducts);
                $restaurantResults[$price] = new \Model\SearchResult($restaurant->getId(), $price);
            }
        }

        ksort($restaurantResults, false);
        return $restaurantResults;
    }
}