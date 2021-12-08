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
    <title>Seznam zaměstnanců</title>
</head>
<body>
    <div class="container">
        <?php
              $order= filter_input(INPUT_GET,"order");
              switch($order){
                  case"name_up":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY employee.surname'); break;
                  case"name_down":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY employee.surname DESC'); break;
                  case"room_up":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY room.name');break;
                  case"room_down":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY room.name DESC');break;
                  case"phone_up":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY room.phone');break;
                  case"phone_down":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY room.phone DESC');break;
                  case"job_up":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY employee.job');break;
                  case"job_down":$stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY employee.job DESC');break;
                  default: $stmt = $pdo -> query('SELECT employee_id, employee.name AS empname, surname, room.name AS roomname, room.phone AS phone, job ,room_id FROM employee INNER JOIN room ON employee.room=room.room_id ORDER BY employee.surname'); break;
              }
              if($stmt-> rowCount()==0){
                  echo"Databáze neobsahuje žádná data";
              }
              else{
                  echo "<table class='table table-light'>";
                  echo "<thead><tr><td>Jméno <a href='employees.php?order=name_up'><i class='bi bi-arrow-up'></i></a>  <a href='employees.php?order=name_down'><i class='bi bi-arrow-down'></i></a></td>
                          <td>Místnost <a href='employees.php?order=room_up'><i class='bi bi-arrow-up'></i></a>  <a href='employees.php?order=room_down'><i class='bi bi-arrow-down'></i></a></td>
                          <td>Telefon <a href='employees.php?order=phone_up'><i class='bi bi-arrow-up'></i></a>  <a href='employees.php?order=phone_down'><i class='bi bi-arrow-down'></i></a></td>
                          <td>Pozice <a href='employees.php?order=job_up'><i class='bi bi-arrow-up'></i></a>  <a href='employees.php?order=job_down'><i class='bi bi-arrow-down'></i></a></td></thead>";
                  echo "<tbody>";
              }
            while ($row = $stmt->fetch()){
             
                    echo"<tr><td><a href='employee.php?employee_id={$row ->employee_id}'>{$row->surname} {$row-> empname}</a></td><td>{$row -> roomname}</td><td>{$row->phone}</td><td>{$row ->job}</td></tr>";
            }
            echo"</tbody>";
        ?>
    </div>
</body>
</html>