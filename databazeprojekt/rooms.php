<?php
 require_once ("connect.php");
 $pdo = DB::connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>Seznam místností</title>
</head>
<body>
    <div class="container">
    
        <?php
         $order= filter_input(INPUT_GET,"order");
            switch($order){
                case"name_up":$stmt = $pdo -> query('SELECT * FROM room ORDER BY `name`'); break;
                case"name_down":$stmt = $pdo -> query('SELECT * FROM room ORDER BY `name` DESC'); break;
                case"no_up":$stmt = $pdo -> query('SELECT * FROM room ORDER BY `no`');break;
                case"no_down":$stmt = $pdo -> query('SELECT * FROM room ORDER BY `no` DESC');break;
                case"phone_up":$stmt = $pdo -> query('SELECT * FROM room ORDER BY `phone` ');break;
                case"phone_down":$stmt = $pdo -> query('SELECT * FROM room ORDER BY `phone` DESC ');break;
                default: $stmt = $pdo -> query('SELECT * FROM room ORDER BY `name`'); break;
            }
            if($stmt-> rowCount()==0){
                echo"Databáze neobsahuje žádná data";
            }
            else{
                echo "<table class='table table-light'>";

                echo "<thead><tr><td>Název<a href='rooms.php?order=name_up'><i class='bi bi-arrow-up'></i></a> <a href='rooms.php?order=name_down'><i class='bi bi-arrow-down'></i></a></td>";
                echo"            <td>Číslo<a href='rooms.php?order=no_up'><i class='bi bi-arrow-up'></i></a>  <a href='rooms.php?order=no_down'><i class='bi bi-arrow-down'></i></a></td>";
                 echo"           <td>Telefon<a href='rooms.php?order=phone_up'><i class='bi bi-arrow-up'></i></a>  <a href='rooms.php?order=phone_down'> <i class='bi bi-arrow-down'></i></a></td></thead>";
                echo "<tbody>";
            }
            while ($row = $stmt->fetch()){
                echo"<tr><td><a href='room.php?room_id={$row ->room_id}'>{$row->name}</a></td><td>{$row -> no}</td><td>".($row->phone ?:"&mdash;")."</td></tr>";
            }
        ?>
    </div>
</body>
</html>