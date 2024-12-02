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
      foreach ($results as $country){
        echo "<h2>{$country['name']}</h2>";
        echo "<p><strong>Capital:</strong> {$country['capital']}</p>";
        echo "<p><strong>Region:</strong> {$country['region']}</p>";
        echo "<p><strong>Population:</strong> {$country['population']}</p>";
        echo "<p><strong>Head of State:</strong> {$country['head_of_state']}</p>";
        echo "<hr>";
      }
    }else{
      echo "<p>No Such Result Found for: '{$name_of_country}'</p>";
    }
  }else{
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($results){
      foreach ($results as $country){
        echo "<h2>{$country['name']}</h2>";
        echo "<p><strong>Capital:</strong> {$country['capital']}</p>";
        echo "<p><strong>Region:</strong> {$country['region']}</p>";
        echo "<p><strong>Population:</strong> {$country['population']}</p>";
        echo "<p><strong>Head of State:</strong> {$country['head_of_state']}</p>";
        echo "<hr>";
    }
  }else{
    echo "<p>No Countries Found.</p>";
  }
}
}catch(PDOException $e){
  echo "<p>Connection Failed: {$e->getMessage()}</p>";
}


?>

