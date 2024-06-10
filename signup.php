<?php 
session_start();

include("conn.php");
include("function.php");

function random_num($length) {
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) { 
        $text .= rand(0, 9);
    }

    return $text;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        //save to database
        $user_id = random_num(20);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = $conn->prepare("INSERT INTO users (user_id, user_name, password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $user_id, $user_name, $hashed_password);
        $query->execute();

        header("Location: login.php");
        die;
    } else {
        echo "Please enter some valid information!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f2f2f2;
            font-family: 'Roboto', sans-serif;
        }

        #box {
            background: ;
            border-radius:#fff 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 40px;
            width: 300px;
            text-align: center;
        }

        #box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        #text {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #013220;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        #button:hover {
            background: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="box">
        <h2>Signup</h2>
        <form method="post">
            <input id="text" type="text" name="user_name" placeholder="Username"><br>
            <input id="text" type="password" name="password" placeholder="Password"><br>
            <input id="button" type="submit" value="Signup"><br>
            <a href="login.php">Click to Login</a>
        </form>
    </div>
</body>
</html>
