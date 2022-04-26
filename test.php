<?php

use TelematicsApi\Telematics;

require "src/Telematics.php";

$telematics = new Telematics('$2y$10$t/QmaMwineu2pXDQbs/tjeX6.05U1V5CLUAO4wv1p4mL2MxGS4laq','id');
$res = $telematics->get_travelsheet_report([3680],'2022-04-24 08:05:00','2022-04-26 12:00:00', true);
echo(json_encode($res));
?>