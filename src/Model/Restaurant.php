<?php

namespace Model;


class Restaurant
{
    private $id;

    private $items;

    /**
     * Restaurant constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = (int) $id;
        $this->items = [];
    }

    public function addItem($name, $price) {
        $this->items[str_replace(' ', '', $name)] = (float) $price;
    }

    public function getItems(){
        return $this->items;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function haveItems($products){
        foreach ($products as $product) {
            if (!isset($this->items[$product])) {
                return false;
            }
        }
        return true;
    }

    public function getPriceItems($products){
        $price = 0;
        foreach ($products as $product) {
            $price += $this->items[$product];
        }
        return $price;
    }

    public function addItems($data) {
        if(!isset($data[0], $data[1]) || $this->id != $data[0]) {
            throw new \ErrorException('Restaurant data is invalid. Data : ' . json_encode($data));
        }

        $arraySize = count($data);
        for($i = 2; $i <= $arraySize; $i++){
            if(isset($data[$i]) && $data[$i]) {
                $this->addItem($data[$i], $data[1]);
            }
        }
    }

    public static function restore(array  $data = []){
        if(!isset($data[0], $data[1])) {
            throw new \ErrorException('Restaurant data is invalid. Data : ' . json_encode($data));
        }

        $model = new self((int) $data[0]);
        $arraySize = count($data);
        for($i = 2; $i <= $arraySize; $i++){
            if(isset($data[$i]) && $data[$i]) {
                $model->addItem($data[$i], $data[1]);
            }
        }

        return $model;
    }
}