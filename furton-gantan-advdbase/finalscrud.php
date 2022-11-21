<?php
    #connector
    try
    {
        require_once __DIR__ . "./vendor/autoload.php";
        // connect to mongodb
        $client = new MongoDB\Client("mongodb+srv://marklembu:markpogi09@cluster0.4hb6gax.mongodb.net/test");
        $sample_restaurants = $client->sample_restaurants;
        $restaurants = $sample_restaurants->restaurants;
    }
        catch(MongoConnectionException $e) {
            die("Failed to connect to database ".$e->getMessage());

        }
