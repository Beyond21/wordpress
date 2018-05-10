<!-- <?php

include 'class.IPInfoDB.php';

// Load the class
$ipinfodb = new IPInfoDB('6d591490c82285fc270b8f76231106ee37ddb23f4f0c744a9eb1ff46a64009a3');

$results = $ipinfodb->getCity($_SERVER['REMOTE_ADDR']);
// $errors = $ipinfodb->getError();

// Getting the result
echo "Result
\n";
if (!empty($results) && is_array($results)) {
	foreach ($results as $key => $value) {
		echo $key . ' : ' . $value . "
\n";
	}
}

// Show errors
if (!empty($errors) && is_array($errors)) {
	echo "Errors
\n";

	foreach ($errors as $error) {
		echo $error . "
\n";
	}
} -->