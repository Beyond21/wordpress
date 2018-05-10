<?php


session_start();
include 'connector.php';

// var_dump($_SERVER);

// Does not have Cookie
if (!isset($_COOKIE['user_id_cookie'])) {
    $sid = create_first_imp();
    $_SESSION['session_id'] = $sid;
    setcookie('user_id_cookie', $guid, time() + (10 * 365 * 24 * 60 * 60),"/");
    
} 

// Have cookie - save his events

else {
	var_dump($_SERVER['REQUEST_URI']);
	$event = create_event();
}


$aff = intval($_GET['aff']);

$phpData      = (object) [];
$phpData->aff = $aff;

// $phpData->sid = $_SESSION["session_id"];
echo "<br>my guid: " . $_COOKIE['user_id_cookie'];
echo "<br> sid: " . $_SESSION['session_id'];
?>


<script>
var phpData = <?php echo json_encode($phpData); ?>;

    
</script>