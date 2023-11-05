<?php

/**
 * Configuration for local development database connection
 *
 */

$host       = "zuzanagabonayova.eu";
$username   = "zuzanagabonayova_euwebshopdb";
$password   = "dwp2023";
$dbname     = "zuzanagabonayova_euwebshopdb";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);