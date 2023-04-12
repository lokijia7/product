<!DOCTYPE html>

<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
?>

<html>

<head>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PDO - Create a Record - PHP CRUD Tutorial</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    </head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        header {
            text-align: center;
            padding: 50px 0;
        }

        main section {
            padding: 50px;
            text-align: center;
        }

        main section h2 {
            margin-bottom: 30px;
        }

        main section ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        main section li {
            margin: 0 20px 40px;
            max-width: 300px;
            text-align: center;
        }

        main section li img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        main section li h3 {
            margin: 0;
            font-size: 24px;
        }

        main section li p {
            margin: 10px 0;
        }

        main section li button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        main section li button:hover {
            background-color: #555;
        }

        footer {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }
    </style>

<body>
    <?php include 'nav.php' ?>
    <header>
        <h1>Contact Us</h1>

    </header>
    <main>
        <section>
            <h2>If you have any questions, please contact us!</h2>
            <p>Phone No.:03 88888888</p>
            <p>E-mail:myproduct@gmail.com</p>
            <p>Address:603 S Club Ct<br>Hermitage, Tennessee(TN), 37076</p>
        </section>
    </main>
</body>

</html>