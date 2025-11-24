<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = trim($_GET['country']);

    
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $row) {
            echo "Name: " . htmlspecialchars($row['name'] ?? '') . "<br>";
            echo "Continent: " . htmlspecialchars($row['continent'] ?? '') . "<br>";
            echo "Population: " . htmlspecialchars($row['population'] ?? '') . "<br>";
            echo "Capital: " . htmlspecialchars($row['capital'] ?? '') . "<hr>";
        }
    } else {
        echo "No country found matching '" . htmlspecialchars($country) . "'.";
    }

} else {
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2> All Countries </h2>";
    echo "<ul>";
    foreach ($results as $row){
      echo "<li>";
      echo "Name: " . htmlspecialchars($row['name'] ?? '') . "<br>";
      echo "Continent: " . htmlspecialchars($row['continent'] ?? '') . "<br>";
      echo "Population: " . htmlspecialchars($row['population'] ?? '') . "<br>";
      echo "Capital: " . htmlspecialchars($row['capital'] ?? '') . "<hr>";
      echo "</li><hr>";
        
    }
    echo "</ul>";
}
?>