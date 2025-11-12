<?php

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Departments and Employees</title>
</head>
<body>
<br><br>
<button>Department new</button>
<button>Department list</button>
<button>Employee new</button>
<button>Employee list</button>
<br><br>
<form action="">
    Gender<input type="radio" name="gender" value="female">female
    <input type="radio" name="gender" value="male">male
    <input type="radio" name="gender" value="divers">divers
    <br><br>
    First Name <input type="text" name="firstName">
    Last Name  <input type="text" name="lastName">
    Department <select id="departmentId">
        <option value="1">HR</option>
        <option value="2">Verkauf</option>
        <option value="3">Produktion</option>
    </select>
</form>
</body>
</html>
