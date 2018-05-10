<?php
//starts a session:
session_start();

//The Connector.php is including these following files and connect to the DB and return the connection:'get-browser.php':'get-country.php'; 'get-device.php'; 'get-source.php'; 'create_guid.php'; 'create-first-imp.php'; 'create-event.php':

include 'connector.php';

// in case no co cookie is set:

if (!isset($_COOKIE['user_id_cookie'])) {
    $sid = create_first_imp();
    $_SESSION['session_id'] = $sid;

    $_SESSION['remaining_pages'] = mt_rand(1,8);
    echo $_SESSION['remaining_pages'];

    setcookie('user_id_cookie', $guid, time() + (10 * 365 * 24 * 60 * 60),"/");
} 

// if cookie exists so create and save his events

else {
	$event = create_event();

}

echo "my cookie: " . $_COOKIE['user_id_cookie'];
echo " sid: " . $_SESSION['session_id'];
echo $results;


//collectin data from URL to send to Javascript:
// $phpData      = (object) [];
// $phpData->sid = $_SESSION["session_id"];

?>

<!-- sending all the data to javascript 
 -->

<!-- <script>
var phpData = <?php echo json_encode($phpData); ?>;
</script> -->