<?php

use TelematicsApi\Telematics;

require "src/Telematics.php";

$telematics = new Telematics('$2y$10$M68qGpTyMnN0Rb8ML9gJAus0zxrZMSfNnDL/BWwKyOCP7HhSYtTbi','id');
// $res = $telematics->get_travelsheet_report([237],'2022-07-12','2022-07-13', false, 10);
$res = $telematics->get_event_report([237],'2022-07-14','2022-07-15');
// $res = $telematics->get_ignition_report([237],'2022-07-12','2022-07-13');
// $res = $telematics->get_object_history_report([237],'2022-07-14 00:00:00','2022-07-14 00:10:00');
echo(json_encode($res));
?>