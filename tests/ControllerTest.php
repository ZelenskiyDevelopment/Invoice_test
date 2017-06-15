<?php

namespace Tests;

use Controller;
use Model\Restaurant;

class ControllerTest extends TestCase
{

    private $controller;

    /**
     * ControllerTest constructor.
     */
    public function __construct()
    {
        $this->controller = new Controller(['fileCvPath' => $GLOBALS['fileCvPath']]);
    }

    public function testGetRestaurants(){
        $restaurants = $this->controller->getRestaurants();
        $this->assertEquals(6, count($restaurants));

        $model = reset($restaurants);
        $this->assertEquals(Restaurant::class, get_class($model));
        $this->assertEquals(2, count($model->getItems()));
    }

    public function testGetOptimalRestaurant()
    {
        $restaurantOne = new Restaurant(1);
        $restaurantOne->addItem('a', 12.2);
        $restaurantOne->addItem('b', 8.5);

        $restaurantTwo = new Restaurant(2);
        $restaurantTwo->addItem('a',10);
        $restaurantTwo->addItem('b', 30);
        $restaurantTwo->addItem('c', 5);

        $this->controller->setRestaurants([$restaurantOne, $restaurantTwo]);

        $result = $this->controller->getOptimalRestaurant(['a']);
        $this->assertEquals(2, $result->getRestaurantId());
        $this->assertEquals(10, $result->getPrice());

        $result = $this->controller->getOptimalRestaurant(['b']);
        $this->assertEquals(1, $result->getRestaurantId());
        $this->assertEquals(8.5, $result->getPrice());

        $result = $this->controller->getOptimalRestaurant(['a', 'b']);
        $this->assertEquals(1, $result->getRestaurantId());
        $this->assertEquals(20.7, $result->getPrice());

        $result = $this->controller->getOptimalRestaurant(['a', 'b', 'c', 'd']);
        $this->assertEquals(true, $result == null);
    }

}
