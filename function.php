<?php

function check_login($conn)
{
    if(isset($_SESSION['user_id']))
    {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // Redirect to login
    header("Location: login.php");
    die;
}
?>


<!-- }

function random_num($length)
{

	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		# code...

		$text .= rand(0,9);
	}

	return $text;
} -->