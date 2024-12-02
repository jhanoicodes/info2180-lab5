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

//CITY START
    if (isset($_GET['cities']) && $_GET['cities'] == 'true'){
      $stmt = $conn->prepare("SELECT city.name, city.district, city.population FROM cities AS city JOIN countries AS country ON city.country_code = country.code WHERE country.name LIKE :country");
      $stmt->bindValue(':country', '%' . $name_of_country . '%');
      $stmt->execute();

      $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($cities){
        echo "<h2>Cities Found In {$name_of_country}</h2>";
        echo "<table border='1'>";
        echo "<tr>
              <th>City Name</th>
              <th>District</th>
              <th>Population</th>
            </tr>";
      foreach ($cities as $city){
        echo "<tr><td>" . htmlspecialchars($city['name']) . "</td>
              <td>" . htmlspecialchars($city['district']) . "</td>
              <td>" . htmlspecialchars($city['population']) . "</td>
              </tr>";
      }
      echo "</table>";
    }else{
      echo "<p>No Cities Found for: '{$name_of_country}'</p>";
    }
//CITY END
  }else{
//COUNTRY
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
  }
} else{
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

