<?php

class Logger{

    /**
     * @param string $message
     */
    public static function errorPrint($message){
        print_r("\t" . $message . "\n");
        die();
    }

    /**
     * @param \Model\SearchResult $result
     */
    public static function resultPrint($result)
    {
        printf("Restaurant: %d\n", $result->getRestaurantId());
        printf("Total cost: %.02f\n", $result->getPrice());
    }

    public static function resultNotFoundPrint(){
        echo "Restaurant: none\n";
    }
}