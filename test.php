<?php

use TelematicsApi\Telematics;

require "src/Telematics.php";

$telematics = new Telematics('$2y$10$PVsJ6YmyKwAcy9ym0H9MaOV1S6AYlhP8lVUC2lxpFvkq2sDPb/5L.','id');
// $res = $telematics->get_travelsheet_report([237],'2022-07-12','2022-07-13', false, 10);
// $res = $telematics->get_temperature_report([237],'2022-07-12','2022-07-13');
// $res = $telematics->get_ignition_report([237],'2022-07-12','2022-07-13');
$res = $telematics->get_object_history_report([237],'2022-07-14 00:00:00','2022-07-14 00:10:00');
echo(json_encode($res));
?>