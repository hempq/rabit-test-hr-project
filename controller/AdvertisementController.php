<?php
    require 'model/Advertisement.php';
    require 'service/AdvertisementService.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class AdvertisementController 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new AdvertisementService($this->objconfig);
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
		public function checkValidation($advertisementttb)
        {    $noerror=true;     
            // Validate title            
            if(empty($advertisementttb->title)){
                $advertisementttb->title_msg = "Field is empty.";$noerror=false;     
            } elseif(!filter_var($advertisementttb->title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $advertisementttb->title_msg = "Invalid entry.";$noerror=false;
            }else{$advertisementttb->title_msg ="";}
            return $noerror;
        }

        // add new record
		public function insert()
		{
            try{
                $advertisementttb=new Advertisement();
                if (isset($_POST['addbtn'])) 
                {   
                    // read form value
                    $advertisementttb->title = trim($_POST['title']);
                    $advertisementttb->user_id = trim($_POST['user_id']);
                    //call validation
                    $chk=$this->checkValidation($advertisementttb);                    
                    if($chk)
                    {   
                        //call insert record            
                        $pid = $this -> objsm ->insertRecord($advertisementttb);
                        if($pid>0){			
                            $this->list();
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {    
                        $_SESSION['advertisementttbl0']=serialize($advertisementttb);//add session obj           
                        $this->pageRedirect("view/advertisementInsert.php");                
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
                    $advertisementttb=unserialize($_SESSION['advertisementttbl0']);
                    $advertisementttb->id = trim($_POST['id']);
                    $advertisementttb->title = trim($_POST['title']);                    
                    // check validation  
                    $chk=$this->checkValidation($advertisementttb);
                    if($chk)
                    {
                        $res = $this -> objsm ->updateRecord($advertisementttb);	                        
                        if($res){			
                            $this->list();                           
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {         
                        $_SESSION['advertisementttbl0']=serialize($advertisementttb);      
                        $this->pageRedirect("view/advertisementUpdate.php");                
                    }
                }elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
                    $id=$_GET['id'];
                    $result=$this->objsm->selectRecord($id);
                    $row=mysqli_fetch_array($result);  
                    $advertisementttb=new Advertisement();                  
                    $advertisementttb->id=$row["id"];
                    $advertisementttb->title=$row["title"];
                    $_SESSION['advertisementttbl0']=serialize($advertisementttb);
                    $this->pageRedirect('view/advertisementUpdate.php');
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
                        $this->pageRedirect('advertisement.php');
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
            include "view/advertisementList.php";                                        
        }
    }
		
	
?>