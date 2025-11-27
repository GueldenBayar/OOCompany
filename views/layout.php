<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employees && Departments</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        nav {
            background-color: #eee;
            padding: 10px;
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 20px;
            text-decoration: none;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            background: #ddd;
            text-decoration: none;
            border: 1px solid #ccc;
            color: black;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav>
        <a href="../index.php?action=departments">Departments</a>
        <a href="../index.php?action=employees">Employees</a>
    </nav>
    <div>
        <?php include $viewPath; ?>
    </div>
</body>
</html>
