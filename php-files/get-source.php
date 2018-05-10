<?php

function source() {

$temp = $_SERVER['HTTP_REFERER'];

if ($temp) {
    // var_dump('went in, it means that an the string that came back from the server is NOT empty, so appending its content to var');
    return $temp;

}
else 
	{
		// var_dump('Didnt go in, it means thatthe string that came back from the server is empty, so var sholud stay null');
    return null;
}



}

?>