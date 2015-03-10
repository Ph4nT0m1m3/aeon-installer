<?php $app_info = file_get_contents('version.json')?>
<?php $app_info = json_decode($app_info) ?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Aeon Project Installer</title>
        <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="../public/assets/css/material.css"> 
        <link rel="stylesheet" href="../public/assets/css/material-wfont.css">
        <link rel="stylesheet" href="../public/assets/css/ripples.css"> 
        <link rel="stylesheet" type="text/css" href="../public/assets/css/font-awesome.css">
        <style>
            #output
            {
                width:100%;
                height:250px;
                overflow-y:scroll;
                overflow-x:hidden;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h2 align="center">Installing <?php echo "{$app_info->name}-v{$app_info->version}.{$app_info->minor_revision}.{$app_info->patch}"  ?> <small>(build <?php echo"#{$app_info->build}"  ?>)</small></h2>
            <div class="col-lg-2">
                
            </div>
            <div class="col-lg-8">
                            <div class="dialogbox">
                <p>You are about to install <span class="label label-success"><?php echo "{$app_info->name}" ?></span> version <?php 
                echo "{$app_info->version}.{$app_info->minor_revision}.{$app_info->patch}" ?>. Please keep in mind that this application is primarily made for Cebu Technological University of Tuburan, if you're going to use or study this Project please give a proper credits to the Developers of this Application.</p>
               
                <input type="hidden" value="false" id="check">
                
                <div id="user" class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">User Configuration</h3>
                    </div>
                    <div class="panel-body">
                        <form action="users.php" method="POST">
                            <input type="text" class="form-control" name="user" id="user" placeholder="Username">
                            <input type="text" class="form-control" name="pass" id="pass" placeholder="Password">
                            <input type="submit" class="btn btn-material-pink" value="User Setup">
                        </form>
                    </div>
                    <div id="userFoot" class="panel-footer">
                    </div>
                </div> 
            </div>
            <div class="col-lg-2">
                
            </div>
    </div>
    </body>
    <script type="text/javascript" src="../public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="../public/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../public/assets/js/material.js"></script>
    <script type="text/javascript" src="../public/assets/js/ripples.js"></script>
</html>