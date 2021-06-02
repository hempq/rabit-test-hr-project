<?php
    require 'model/User.php';
    require 'service/UserService.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class UserController 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new UserService($this->objconfig);
		}

        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) 
			{
                case 'add' :                    
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this -> delete();
					break;								
				default:
                    $this->list();
			}
		}

        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}

        // check validation
		public function checkValidation($userttb)
        {    $noerror=true;     
            // Validate name            
            if(empty($userttb->name)){
                $userttb->name_msg = "Field is empty.";$noerror=false;     
            } elseif(!filter_var($userttb->name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $userttb->name_msg = "Invalid entry.";$noerror=false;
            }else{$userttb->name_msg ="";}
            return $noerror;
        }

        // add new record
		public function insert()
		{
            try{
                $userttb=new User();
                if (isset($_POST['addbtn'])) 
                {   
                    // read form value
                    $userttb->name = trim($_POST['name']);
                    //call validation
                    $chk=$this->checkValidation($userttb);                    
                    if($chk)
                    {   
                        //call insert record            
                        $pid = $this -> objsm ->insertRecord($userttb);
                        if($pid>0){			
                            $this->list();
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {    
                        $_SESSION['userttbl0']=serialize($userttb);//add session obj           
                        $this->pageRedirect("view/userInsert.php");                
                    }
                }
            }catch (Exception $e) 
            {
                $this->close_db();	
                throw $e;
            }
        }

        // update record
        public function update()
		{
            try
            {
                
                if (isset($_POST['updatebtn'])) 
                {
                    $userttb=unserialize($_SESSION['userttbl0']);
                    $userttb->id = trim($_POST['id']);
                    $userttb->name = trim($_POST['name']);                    
                    // check validation  
                    $chk=$this->checkValidation($userttb);
                    if($chk)
                    {
                        $res = $this -> objsm ->updateRecord($userttb);	                        
                        if($res){			
                            $this->list();                           
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {         
                        $_SESSION['userttbl0']=serialize($userttb);      
                        $this->pageRedirect("view/userUpdate.php");                
                    }
                }elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                    $id=$_GET['id'];
                    $result=$this->objsm->selectRecord($id);
                    $row=mysqli_fetch_array($result);  
                    $userttb=new User();                  
                    $userttb->id=$row["id"];
                    $userttb->name=$row["name"];
                    $_SESSION['userttbl0']=serialize($userttb);
                    $this->pageRedirect('view/userUpdate.php');
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }

        // delete record
        public function delete()
		{
            try
            {
                if (isset($_GET['id'])) 
                {
                    $id=$_GET['id'];
                    $res=$this->objsm->deleteRecord($id);                
                    if($res){
                        $this->pageRedirect('user.php');
                    }else{
                        echo "Somthing is wrong..., try again.";
                    }
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }

        //list
        public function list(){
            $result=$this->objsm->selectRecord(0);
            include "view/userList.php";                                        
        }
    }
		
	
?>