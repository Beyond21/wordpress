<?php

function create_event() {
	$temp_coockie_string = $_COOKIE['_ga'];
	    $ga_c = $temp_coockie_string;
    // $ga_c                = substr($temp_coockie_string, -20);
	echo "this is taken from the create-event file: <br>";
    echo 'Google client-id: ' . $ga_c.'<br>';
    echo "my cookie: " . $_COOKIE['user_id_cookie']. '<br>';


	
    $source = source();
    echo $source;


      $sid = $_SESSION['session_id'];
    echo '<br> sid: ' . $sid . '<br';
    $current_url = ($_SERVER['REQUEST_URI']);


//     $sid = $_COOKIE['session_id_cookie'];
// echo $sid;
	// $servername = "gator3093.hostgator.com";
	// $username = "talnitza_beyond";
	// $password = "Drallinone21@";
	// $dbname = "talnitza_compare";
// 	$sid = $_COOKIE['session_id_cookie'];

	// function removeqsvar($source) {

	// 	return preg_replace('/\\?.*/', '', $source);};

	$conn = connect_to_db();
    $sql = sprintf("INSERT INTO events (user_id, source, g_client_id) VALUES (%d, '%s', '%s')", $sid, $source, $ga_c);
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully </br> ";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;

	}

	

	

	// // $uid=mysqli_insert_id($conn);

	

	


	// $conn->close
}

?>