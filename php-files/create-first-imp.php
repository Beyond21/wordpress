<?php


function create_first_imp() {
    $source = source();
	$mob_or_desk = getmobodresk();
	$browserAgent = $_SERVER['HTTP_USER_AGENT'];
	$ip1 = $results['ipAddress'];
	$country = $results['countryName'];
	$city = $results['cityName'];
	$timz_zone=$results['timeZone'];
	$browser = getbrowser();

	$conn = connect_to_db();

	$sql = sprintf("INSERT INTO imp (source, ip, country, city, time_zone, ua, desk_mob, browser)

	VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $source, $results['ipAddress'], $results['countryName'], $results['cityName'], $results['timeZone'], $browserAgent, $mob_or_desk, $browser );

	// $sql = sprintf("INSERT INTO imp (g_client_id, source, ip, country, city, time_zone, ua, age, desk_mob, browser)

	// VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '55', '%s', '%s')", $ga_c, $source, $results['ipAddress'], $results['countryName'], $results['cityName'], $results['timeZone'], $browserAgent, $mob_or_desk, $browser );
// var_dump($sql);


	if ($conn->query($sql) === TRUE) {
		$sid= mysqli_insert_id($conn);
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$sid=mysqli_insert_id($conn);
	$conn->close();
	return $sid;
}

?>