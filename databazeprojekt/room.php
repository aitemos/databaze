<?php
require_once ("connect.php");
$state = "OK";
$roomId = filter_input(INPUT_GET,"room_id",FILTER_VALIDATE_INT);
if($roomId === null){
    http_response_code(400);
    $state ="BadRequest";
}
else{
    $queryroom = "SELECT * FROM room WHERE room_id =:roomId";
    $queryemployee = "SELECT * FROM employee WHERE room=:roomId";
    $querykey = "SELECT * FROM `key` WHERE room=:roomId";
    $pdo = DB::connect();
    $stmt = $pdo -> prepare($queryroom);
    $stmt -> execute([$roomId]);
    if($stmt ->rowCount()==0){
        http_response_code(404);
        $state = "NotFound";
    }
    else{
        $room = $stmt -> fetch();
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
    <title><?php if($state ==="OK"){echo"Karta místnosti: {$room->name}</title>";}elseif($state ==="NotFound"){echo "404 NotFound</title>"; echo "<h1>Místnost nenalezena</h1>";exit;}elseif($state ==="BadRequest"){echo"400 BadRequest</title>";echo "<h1>Chybný požadavek</h1>";exit;}?></head>
<body>
    <div class="container">
    <?php 
    
    if($state ==="OK"){
        echo "<dl class='dl-horizontal'>";
        echo "<h1>Karta místnosti: ".$room-> name."</h1>";  
        echo "<dt>Název:</dt><dd>{$room -> name}</dd>";
        echo "<dt>Číslo:</dt><dd>{$room-> no}</dd>";
        echo "<dt>Telefon:</dt><dd>{$room-> phone}</dd>";
        $stmt = NULL;
        $stmt = $pdo -> prepare($queryemployee);
        $stmt -> execute([$roomId]);
       
        echo "<dt>Lidé:</dt> ";  
        $avgsalary = 0;
        $count=0;
        $salary =0;
        if($stmt-> rowCount()==0){
            echo"<dd>&mdash;</dd>";
        }
        else{
            while($row = $stmt->fetch()){
            
                echo "<dd><a href='employee.php?employee_id={$row ->employee_id}'>{$row->name} {$row->surname}</dd></a>";
                $salary+= $row -> wage;
                $count++;
            }
            $avgsalary=$salary/$count;
            echo "<dt>Průměrná Mzda:</dt><dd>{$avgsalary} </dd>";
        }
      
        
        $stmtk = $pdo -> prepare('SELECT k.employee, k.room, e.name, e.surname, e.employee_id FROM `key` k INNER JOIN employee e ON k.employee=e.employee_id WHERE k.room=:roomId');
        $stmtk -> execute([$roomId]);
        echo "<dt>Klíče:</dt>";
        if($stmtk-> rowCount()==0){
            echo" <dd> &mdash;</dd>";
        }
        else{
            while($row = $stmtk->fetch()){
                echo "<dd> <a href='employee.php?employee_id={$row ->employee_id}'>{$row -> surname} {$row-> name}</a></dd>";
        }
        }
       
        echo "</br>";
        echo "<a href='rooms.php'><i class='bi bi-arrow-left'></i> Zpět na seznam místností<a/>";
    }
   
    
     
    ?>
</div>
</body>
</html>