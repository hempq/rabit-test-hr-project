<?php
        require '../model/User.php'; 
        session_start();             
        $userttb=isset($_SESSION['userttbl0'])?unserialize($_SESSION['userttbl0']):new User();            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update User</h2>
                    </div>
                    <form action="../user.php?act=update" method="post" >
                        <div class="form-group <?php echo (!empty($userttb->name_msg)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $userttb->name; ?> ">
                            <span class="help-block"><?php echo $userttb->name_msg;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $userttb->id; ?>"/>
                        <input type="submit" name="updatebtn" class="btn btn-primary" value="Submit">
                        <a href="../user.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>