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
        echo "<h2>Results for '<strong>" . htmlspecialchars($country) . "</strong>'</h2>";
        echo "<table border= '1' cellpadding='5' cellspacing='0'>";
        echo "<thead>
                <tr>
                  <th>Country Name</th>
                  <th>Continent</th>
                  <th>Independence Year</th>
                  <th>Head of State</th>
                </tr>
              </thead>";
        echo "<tbody>";
        foreach ($results as $row){
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['continent'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['independence_year'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['head_of_state'] ?? '') . "</td>";
            echo"</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No country found matching '" . htmlspecialchars($country) . "'.";
    }

} else {
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>All Countries</h2>";
    echo "<table border= '1' cellpadding='5' cellspacing='0'>";
    echo "<thead>
<tr>
      <th>Country Name</th>
      <th>Continent</th>
      <th>Independence Year</th>
      <th>Head of State</th>
    </tr>
  </thead>";
    echo "<tbody>";
    foreach ($results as $row){
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['name'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['continent'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['independence_year'] ?? '') . "</td>";
      echo "<td>" . htmlspecialchars($row['head_of_state'] ?? '') . "</td>";
      echo "</tr>";
        
    }
    echo "</tbody></table>";
}
?>