<?php

use TelematicsApi\Telematics;

require "src/Telematics.php";

$telematics = new Telematics('$2y$10$PVsJ6YmyKwAcy9ym0H9MaOV1S6AYlhP8lVUC2lxpFvkq2sDPb/5L.','id');
// $telematics = new Telematics('$2y$10$qczufNe9/KeFTDRm3vphS.7jkoao5PK.U0e/O/1EtQWGrH2L/0fm6','id');
// $res = $telematics->get_travelsheet_report([237],'2022-07-12','2022-07-13', false, 10);
$res = $telematics->get_geofences();
// $res = $telematics->get_ignition_report([237],'2022-07-12','2022-07-13');
// $res = $telematics->get_geofence_report([237],'2022-07-14 00:00:00','2022-07-15 00:00:00',[78,87]);
echo(json_encode($res));
?>