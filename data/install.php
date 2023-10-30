<?php

/**
 * - Connect to the database engine using PDO 
 * - Create a new database and populate it
 *
 */

require "../model/config/dev.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    // File order matters
    $sql_db = file_get_contents("database.sql");
    $sql_structure = file_get_contents("structure.sql");
    $sql_content = file_get_contents("content.sql");

    $connection->exec($sql_db);
    $connection->exec($sql_structure);
    $connection->exec($sql_content);

    echo "<p>Database created and populated successfully. <br><a href='../'>Home</a></p>";
} catch (PDOException $error) {
    echo $error->getMessage();
}