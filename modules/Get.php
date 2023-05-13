<?php
	class Get {
		protected $pdo, $gm;

		public function __construct(\PDO $pdo) {
			$this->gm = new GlobalMethods($pdo);
			$this->pdo = $pdo;
		}

		public function getuserpet($user_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";


			$sql = "SELECT * FROM pet_tbl ";
			if($user_id != null){
				$sql.=" WHERE user_id = $user_id";
			}
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getpet($user_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			
			$sql = "SELECT * FROM pet_tbl ";
			if($user_id != null){
				$sql.=" WHERE user_id = $user_id";
			}
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}
		public function getpetinfo($pet_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			
			$sql = "SELECT * FROM pet_tbl ";
			if($pet_id != null){
				$sql.=" WHERE pet_id = $pet_id";
			}
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getAppointment($user_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			$sql = "SELECT * FROM appointment_tbl  
							INNER JOIN pet_tbl 
							ON appointment_tbl.pet_id = pet_tbl.pet_id ";
			if($user_id != null ){
			$sql.= " WHERE appointment_tbl.user_id = $user_id" ;
			}
			$res = $this->gm->executeQuery($sql);

			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getRequestAppointment($data) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			$sql = "SELECT * FROM appointment_tbl  
							INNER JOIN pet_tbl 
							ON appointment_tbl.pet_id = pet_tbl.pet_id ";

			if($data->user_id != null ){
			$sql.= " WHERE appointment_tbl.user_id = $data->user_id" ;
			}
			$sql.= " AND appointment_tbl.status = '$data->status' " ;

			$res = $this->gm->executeQuery($sql);
			$count = count($res['data']);
			if ($res['code']==200) {
				$payload = [$res['data'],$count];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getPetAppointment($data,$pet_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			$sql = "SELECT * FROM appointment_tbl 
						INNER JOIN pet_tbl 
								ON appointment_tbl.pet_id = pet_tbl.pet_id";
			if($pet_id != null){
				$sql.=" WHERE appointment_tbl.pet_id = $pet_id AND appointment_tbl.app_type = '$data->type' ";
			}
			$res = $this->gm->executeQuery($sql);

			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getAllAppointments(){
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			$sql = "SELECT users.user_id,users.user_fname,users.user_lname,pet_tbl.pet_name,appointment_tbl.app_type,
			appointment_tbl.app_date,appointment_tbl.app_time,appointment_tbl.status
			FROM users,pet_tbl,appointment_tbl
			WHERE users.user_id = pet_tbl.pet_id AND
					users.user_id = appointment_tbl.user_id ";

			
			$res = $this->gm->executeQuery($sql);

			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

	 
	}
?>


<!-- 
@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements AfterViewInit {
  // FOR ALL APPOINTMENTS PAGINATION
  displayedColumns: string[] = ['id', 'name', 'pet', 'service', 'date', 'time', 'status', 'actions'];
  dataSource = new MatTableDataSource<AllAppointments>(ELEMENT_DATA);
  
  @ViewChild(MatPaginator)
  paginator!: MatPaginator;
  countRequest: any;
  requestData:any;
  ngAfterViewInit() {
 
    this.dataSource.paginator = this.paginator;
  }

  // FOR EDIT ACTION, PENDING, AND REQUESTS DIALOG
  constructor(public post: PostService,public dialog: MatDialog,private session: SessionService) 
  {}
    editDialog() {
      const dialogRef = this.dialog.open(EditActionDialog)
        
      dialogRef.afterClosed().subscribe(result => {
        console.log(`Dialog result: ${result}`);
      });
    }

    pending() {
      const dialogRef = this.dialog.open(PendingDialog)
        
      dialogRef.afterClosed().subscribe(result => {
        console.log(`Dialog result: ${result}`);
      });
    }

    request() {
      const dialogRef = this.dialog.open(RequestDialog)
        
      dialogRef.afterClosed().subscribe(result => {
        console.log(`Dialog result: ${result}`);
      });
    }

    clients() {
      const dialogRef = this.dialog.open(ClientsDialog)
        
      dialogRef.afterClosed().subscribe(result => {
        console.log(`Dialog result: ${result}`);
      });
    }
       
  getRequestAppointment()
  {
    let data = {
      user_id: null,
      status: 'Pending'
    };

    this.post.postData('getRequestAppointment', JSON.stringify(data))
    .subscribe((response: any) => {
     console.log(response);
     this.countRequest = response.payload[1];
     this.dataSource = response.payload[0];
    })
    
  }

}

// CONTENTS OF ALL APPOINTMENTS PAGINATION
export interface AllAppointments {
  id: number;
  name: string;
  pet: string;
  service: string;
  date: string;
  time: string;
  status: string;
}

const ELEMENT_DATA: AllAppointments[] = [
  {id: 1, name: 'Shermayne Francisco', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'In progress'},
  {id: 2, name: 'Lola Lapid', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'Pending'},
  {id: 3, name: 'Piolo Paras',pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'Delayed'},
  {id: 4, name: 'Paulo Paras', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'Cancelled'},
  {id: 5, name: 'Adrian Montallana', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'Done'},
  {id: 6, name: 'Kristiane Dizon', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'In progress'},
  {id: 7, name: 'Mirasol Dela Cruz', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'In progress'},
  {id: 8, name: 'Edrian Francisco', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'In progress'},
  {id: 9, name: 'Neil Bitangcol', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'In progress'},
  {id: 10, name: 'Nicole Villa', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'In progress'},
];

/** EDIT ACTION DIALOG */
@Component({
  selector: 'edit-action-dialog',
  templateUrl: 'edit-action-dialog.html',
})
export class EditActionDialog {
  typeControl = new FormControl<Action | null>(null, Validators.required);
  actions: Action[] = [
    {name: 'In Progress'},
    {name: 'Pending'},
    {name: 'Delayed'},
    {name: 'Cancelled'},
    {name: 'Done'},
  ];

  myDatePicker: any;
}

/** PENDING PAGINATION */
@Component({
  selector: 'pending-dialog',
  templateUrl: 'pending-dialog.html',
})
export class PendingDialog implements AfterViewInit {
  // FOR PENDING PAGINATION
  displayedColumns: string[] = ['id', 'name', 'pet', 'date', 'time', 'status'];
  dataSource = new MatTableDataSource<Pending>(PENDING_DATA);

  @ViewChild(MatPaginator)
  paginator!: MatPaginator;

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
  }
}

  

@Component({
  selector: 'request-dialog',
  templateUrl: 'request-dialog.html',
})
export class RequestDialog implements AfterViewInit {
  // FOR REQUESTS PAGINATION 
  displayedColumns: string[] = [ 'id', 'name', 'pet', 'service', 'date', 'time', 'status'];
  dataSource = new MatTableDataSource([
   
    {id: 2, name: 'Lola Lapid', pet: 'Akio', service: 'Grooming', date: '4/12/2023', time: '12:30 PM', status: 'pending'},
  ]);

 constructor(public dialog: MatDialog,private session: SessionService) 
  {

  }
  @ViewChild(MatPaginator)
  paginator!: MatPaginator;

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
 
  }
      
  
  
} -->
