<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try{
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_GET['country']) && !empty($_GET['country'])) {
    $name_of_country = $_GET['country'];

    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', '%' . $name_of_country . '%');
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results){
      echo "<table border='1'>";
      echo "<tr>
              <th>Country Name</th>
              <th>Continent</th>
              <th>Independence</th>
              <th>Head of State</th>
            </tr>";
      foreach ($results as $country){
        echo "<tr>";
        echo "<td>{$country['name']}</td>";
        echo "<td>{$country['continent']}</td>";
        echo "<td>{$country['independence_year']}</td>";
        echo "<td>{$country['head_of_state']}</td>";
        echo "</tr>";
      }
      echo "</table>";
    }else{
      echo "<p>No Such Result Found for: '{$name_of_country}'</p>";
    }
  }else{
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($results){
      echo "<table border='1'>";
      echo "<tr>
              <th>Country Name</th>
              <th>Continent</th>
              <th>Independence</th>
              <th>Head of State</th>
            </tr>";
      foreach ($results as $country){
        echo "<tr>";
        echo "<td>{$country['name']}</td>";
        echo "<td>{$country['continent']}</td>";
        echo "<td>{$country['independence_year']}</td>";
        echo "<td>{$country['head_of_state']}</td>";
        echo "</tr>";
    }
    echo "</table>";
  }else{
    echo "<p>No Countries Found.</p>";
  }
}
}catch(PDOException $e){
  echo "<p>Connection Failed: {$e->getMessage()}</p>";
}


?>

