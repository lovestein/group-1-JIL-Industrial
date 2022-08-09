<?php

include __DIR__ . "./data.php";

$database =  new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME", $DATABASE_USER, $DATABASE_PASSWORD);