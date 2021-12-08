<?php
require_once ("connect.php");
$state = "OK";
$employeeId = filter_input(INPUT_GET,"employee_id",FILTER_VALIDATE_INT);
if($employeeId === null){
    http_response_code(400);
    $state ="BadRequest";
}
else{
   
    $queryemployee = "SELECT * FROM employee WHERE employee_id=:employeeId";
    $pdo = DB::connect();
    $stmt = $pdo -> prepare($queryemployee);
    $stmt -> execute([$employeeId]);
    if($stmt ->rowCount()==0){
        http_response_code(404);
        $state = "NotFound";
    }
    else{
        $employee = $stmt -> fetch();
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title><?php if($state ==="OK"){echo"Karta zaměstnance: {$employee->name} {$employee -> surname} </title>";}elseif($state ==="NotFound"){echo "404 NotFound</title>"; echo "<h1>Místnost nenalezena</h1>";exit;}elseif($state ==="BadRequest"){echo"400 BadRequest</title>";echo "<h1>Chybný požadavek</h1>";exit;}?>
</head>
<body>
    <div class="container">
    <?php 
    echo"<dl class='dl-horizontal'>";
    if($state ==="OK"){
        echo "<h1> Karta osoby: {$employee-> name} {$employee->surname} </h1>";  
        echo "<dt>Jméno:</dt><dd> ".$employee -> name."</dd>";
        echo "<dt>Příjmení:</dt><dd> ".$employee-> surname."</dd>";
        echo "<dt>Pozice:</dt><dd> ".$employee-> job."</dd>";
        echo "<dt>Mzda:</dt><dd> ".$employee-> wage."</dd>";
        $stmt = NULL;
        $stmt = $pdo -> prepare($queryemployee);
        $stmt -> execute([$employeeId]);
       $queryroom = "SELECT * FROM room WHERE room_id=:{$employee->room}";
       $stmtr = $pdo -> prepare($queryroom);
       $stmtr -> execute([$employee->room]);
       $room = $stmtr -> fetch();
       echo "<dt>Místnost:</dt><dd> <a href='room.php?room_id={$room ->room_id}'>{$room->name}</a> </dd>";
       echo "<dt>Klíče:</dt> ";
        $stmtk = $pdo ->prepare('SELECT k.employee, k.room, r.name, r.room_id FROM `key` k INNER JOIN room r ON k.room=r.room_id WHERE k.employee=:employeeId');
        $stmtk -> execute([$employeeId]);
        if($stmtk-> rowCount()==0){
            echo"  <dd>&mdash;</dd>";
        }
        else{
            while($row = $stmtk->fetch()){
                echo "<dd> <a href='room.php?room_id={$row ->room_id}'>{$row -> name}</a></dd>";
            }
        }

        echo "</br>";
        echo "<a href='employees.php'><i class='bi bi-arrow-left'></i>  Zpět na seznam zaměstnanců</a>";
    }
  
    
    
   
    ?>
     </div> 
</body>
</html>