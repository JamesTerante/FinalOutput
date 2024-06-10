<?php
session_start();

include("conn.php");
include("functions.php");

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        //read from database
        $query = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if (password_verify($password, $user_data['password'])) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        $error_message = "Wrong username or password!";
    } else {
        $error_message = "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            background: #fff;
            border-radius: 10px;
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
        .error {
            color: red;
            margin-top: 10px;
        }
        .pic {
            width: 110%;
            height: 110px;
        }
    </style>
</head>
<body>
    <div id="box">
        <img class="pic" src="SITS.PNG">

        <form method="post">
            <input id="text" type="text" name="user_name" placeholder="Username"><br>
            <input id="text" type="password" name="password" placeholder="Password"><br>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <input id="button" type="submit" value="Login"><br>
            <a href="signup.php">Click to Signup</a>
            <?php
            if ($error_message != '') {
                echo '<div class="error">' . $error_message . '</div>';
            }
            ?>
        </form>
    </div>
</body>
</html>
