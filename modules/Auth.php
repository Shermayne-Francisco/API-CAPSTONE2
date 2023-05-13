<?php 
	class Auth {
		protected $pdo, $gm ;

		public function __construct(\PDO $pdo) {
			$this->gm = new GlobalMethods($pdo);
			$this->get = new Get($pdo);
			$this->pdo = $pdo;
		}
		
        public function Login($data)
        {
          
            $payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";


            try {
                $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
                $sql = $this->pdo->prepare($sql);
                $sql->execute([
                    $data->email,
                ]);

                 $res = $sql->fetch(PDO::FETCH_ASSOC);

                if($res && password_verify( $data->password,$res["password"]))
                {
                    
                    $payload = [
                        "user_fname"=>$res["user_fname"],
                        "user_lname"=>$res["user_lname"],
                        "contact"=>$res["contact"],
                        "address"=>$res["address"],
                        "email"=>$res["email"],
                        "id"=>$res["user_id"],
                    ];
                    $code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
                }
                
                return $this->gm->response($payload, $remarks, $message, $code);


            } catch (\Throwable $th) {
                 return $this->gm->response($payload, $remarks, $message, $code);

            }
        }

        public function Admin_Login($data)
        {
          
            $payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";


            try {
                $sql = "SELECT * FROM admin_tbl WHERE email = ? LIMIT 1";
                $sql = $this->pdo->prepare($sql);
                $sql->execute([
                    $data->email,
                ]);

                 $res = $sql->fetch(PDO::FETCH_ASSOC);

                if($res && password_verify( $data->password,$res["password"]))
                {
                    
                    $payload = [
                        "admin_name"=>$res["admin_name"],
                        "email"=>$res["email"],
                        "admin_id"=>$res["admin_id"],
                    ];
                    $code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
                }
                
                return $this->gm->response($payload, $remarks, $message, $code);


            } catch (\Throwable $th) {
                 return $this->gm->response($payload, $remarks, $message, $code);

            }
        }
	}
?>