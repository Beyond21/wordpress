<?php
function getmobodresk()   {
include 'Mobile_Detect.php';
$detect = new Mobile_Detect();

// Check for any mobile device.
if ($detect->isMobile()) {
  return 'mobile';}

else {
    return 'desktop';
}
}
?>