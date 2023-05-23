<?php 
	require_once("./config/Config.php");
	require_once("./modules/Procedural.php");
	require_once("./modules/Global.php");
	require_once("./modules/Get.php");
	require_once("./modules/Post.php");
	require_once("./modules/Auth.php");

	$db = new Connection();
	$pdo = $db->connect();
	$get = new Get($pdo);
	$post = new Post($pdo);
	$auth = new Auth($pdo);

	if (isset($_REQUEST['request'])) {
		$req = explode('/', rtrim($_REQUEST['request'], '/'));
	} else {
		$req = array("errorcatcher");
	}

	switch($_SERVER['REQUEST_METHOD']) {

		case 'POST':
			$d = json_decode(file_get_contents("php://input"));

			switch ($req[0]) {


				// case 'getstudents':
				// 	if (sizeof($req)>1) {
				// 		echo json_encode($get->getStudents($req[1]));
				// 	} else {
				// 		echo json_encode($get->getStudents(null));
				// 	}
				// 	break;

				case 'Register':
					echo json_encode($post->user_register($d));
					break;

				case 'Login':
					echo json_encode($auth->Login($d));
					break;

				case 'addpet':
					echo json_encode($post->addpet($d));
					break;

				case 'getuserpet':
					if(sizeof($req)>1) {
						echo json_encode($get->getuserpet($req[1]));
					}else{
						echo json_encode($get->getuserpet(null));
					}
					break;

				case 'getpet':
					if(sizeof($req)>1) {
						echo json_encode($get->getpet($req[1]));
					}else{
						echo json_encode($get->getpet(null));
					}
					break;

				case 'getpetinfo':
					if(sizeof($req)>1) {
						echo json_encode($get->getpetinfo($req[1]));
					}else{
						echo json_encode($get->getpetinfo(null));
					}
					break;

				case 'test':
					echo json_encode($get->test($d));
					break;

				case 'getPetAppointment':
					if(sizeof($req)>1) {
						echo json_encode($get->getPetAppointment($d,$req[1]));
					}else{
						echo json_encode($get->getPetAppointment($d,null));
					}
					break;

				case 'getPetinfos':
					echo json_encode($get->getPetinfos($data,$req[1]));
					break;

				case 'addAppointment':
					echo json_encode($post->addAppointment($d));
					break;

				case 'addAppoinmentForClient':
					echo json_encode($post->addAppoinmentForClient($d));
					break;

				case 'addHealthForClient':
					echo json_encode($post->addHealthForClient($d));
					break;

				case 'getAppointment':
					echo json_encode($get->getAppointment($req[1]));
					break;

				case 'getRequestAppointment':
					echo json_encode($get->getRequestAppointment($d));
					break;

				case 'getPendingAppointment':
					echo json_encode($get->getPendingAppointment($d));
					break;
		
				case 'getAllAppointments':
					echo json_encode($get->getAllAppointments());
					break;

				case 'updateUsers':
					echo json_encode($post->updateUsers($d,$req[1]));
					break;

				case 'updateAppointment':
					echo json_encode($post->updateAppointment($d,$req[1]));
					break;
					
				case 'updatePassword':
					echo json_encode($post->updatePassword($d,$req[1]));
					break;

				case 'deletePet':
					echo json_encode($post->deletePet($req[1]));
					break;

				case 'Admin_Login':
					echo json_encode($auth->Admin_Login($d));
					break;

				// CARDS 
				case 'getAllRequest':
					echo json_encode($get->getAllRequest());
					break;

				case 'getAllCompleted':
					echo json_encode($get->getAllCompleted());
					break;

				case 'getAllPending':
					echo json_encode($get->getAllPending());
					break;

				case 'getAllClients':
					echo json_encode($get->getAllClients());
					break;
				// END CARDS

				// TABLE
				// CLIENTS TABLE
				case 'getALLClientsInfo':
					echo json_encode($get->getALLClientsInfo());
					break;
				// CLIENTS TABLE


				// VACCINATION REPORTS
				case 'getAllVaccinationReports':
					echo json_encode($get->getAllVaccinationReports());
					break;
				// VACCINATION REPORTS

				// DEWORMING REPORTS
				case 'getAllDewormingReports':
					echo json_encode($get->getAllDewormingReports());
					break;
				// DEWORMING REPORTS

				// HEARTWORM REPORTS
				case 'getAllHeartWormReports':
					echo json_encode($get->getAllHeartWormReports());
					break;
				// HEARTWORM REPORTS

				// GROOMING REPORTS
				case 'getAllGroomingReports':
					echo json_encode($get->getAllGroomingReports());
					break;
				// GROOMING REPORTS

				// OTHER REPORTS
				case 'getAllOtherReports':
					echo json_encode($get->getAllOtherReports());
					break;
				// OTHER REPORTS

				// REQUEST TABLE
				case 'getAllRequestForTable':
					echo json_encode($get->getAllRequestForTable());
					break;
				// REQUEST TABLE
				// END TABLE

				// FETCH INFO
				case 'getSpecificClientInfo':
					echo json_encode($get->getSpecificClientInfo($req[1]));
					break;
				// END INFO

				// PRINT REPORTS
					case 'printVaccinationReports':
						echo json_encode($get->printVaccinationReports());
						break;
					case 'printDewormingReports':
						echo json_encode($get->printDewormingReports());
						break;
					case 'printHeartWormReports':
						echo json_encode($get->printHeartWormReports());
						break;
					case 'printGroomingReports':
						echo json_encode($get->printGroomingReports());
						break;
					case 'printOtherReports':
						echo json_encode($get->printOtherReports());
						break;
				// END PRINT REPORTS
					
				default:
					echo errmsg(400);
					break;
			}
		break;
		default:
			echo errmsg(403);
	}
?>