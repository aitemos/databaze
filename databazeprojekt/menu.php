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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Prohlížeč databáze</title>
</head>
<body><div class="container">
    <h1>Prohlížeč databáze</h1>
    <ul class='list-unstyled'>
        <li><a href="employees.php">Seznam zaměstnanců</a></li>
        <li><a href="rooms.php">Seznam místností<a/></li>
</ul>
</div>
</body>
</html>