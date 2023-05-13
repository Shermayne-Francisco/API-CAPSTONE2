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

				case 'getPetAppointment':
					if(sizeof($req)>1) {
						echo json_encode($get->getPetAppointment($d,$req[1]));
					}else{
						echo json_encode($get->getPetAppointment($d,null));
					}
					break;

				case 'addAppointment':
					echo json_encode($post->addAppointment($d));
					break;

				case 'getAppointment':
					echo json_encode($get->getAppointment($req[1]));
					break;

				case 'getRequestAppointment':
					echo json_encode($get->getRequestAppointment($d));
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
					
				default:
					echo errmsg(400);
					break;
			}
		break;
		default:
			echo errmsg(403);
	}
?>