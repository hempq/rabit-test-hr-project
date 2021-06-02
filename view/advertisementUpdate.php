<?php
require '../model/Advertisement.php';
require '../service/UserService.php';
require_once '../config.php';
session_start();
$advertisementttb = isset($_SESSION['advertisementttbl0']) ? unserialize($_SESSION['advertisementttbl0']) : new Advertisement();
$userService = new UserService(new config());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper {
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
                    <h2>Update Advertisement</h2>
                </div>
                <form action="../advertisement.php?act=update" method="post">
                    <div class="form-group <?php echo (!empty($advertisementttb->title_msg)) ? 'has-error' : ''; ?>">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control"
                               value="<?php echo $advertisementttb->title; ?> ">
                        <span class="help-block"><?php echo $advertisementttb->title_msg; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($advertisementttb->user_id_msg)) ? 'has-error' : ''; ?>">
                        <label>User</label>
                        <select name="user_id" class="form-control" value="<?php echo $advertisementttb->user_id; ?>">
                            <?php
                            foreach ($userService->getListforSelect()->fetch_all() as $row) {
                                echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                            }
                            ?>
                        </select>
                        <span class="help-block"><?php echo $advertisementttb->user_id_msg; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $advertisementttb->id; ?>"/>
                    <input type="submit" name="updatebtn" class="btn btn-primary" value="Submit">
                    <a href="../advertisement.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>