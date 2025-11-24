<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$country = $_GET['country'] ?? '';
$lookup= $_GET['lookup'] ?? '';

if ($lookup === 'cities'){
  $stmt = $conn->prepare("
    SELECT cities.Name, cities.District, cities.Population
    FROM cities
    JOIN countries ON cities.country_code = countries.Code
    WHERE countries.Name = :country
    ORDER BY cities.Population DESC
  
  ");
}else {
   $stmt = $conn->prepare("
      SELECT name, continent, independence_year, head_of_state
      FROM countries
      WHERE Name = :country
    ");
}

$stmt->execute(['country' => $country]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($results) > 0){
  echo "<table border='1'><tr>";
  foreach(array_keys($results[0]) as $col){
    echo "<th>{$col}</th>";
  }

  echo "</tr>";
  foreach($results as $row){
        echo "<tr>";
        foreach($row as $value){
            echo "<td>{$value}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found.</p>";

}


if (isset($_GET['country']) && !empty($_GET['country'])) {
    $country = trim($_GET['country']);

    
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


