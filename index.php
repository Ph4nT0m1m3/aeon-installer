<?php $app_info = file_get_contents('archive/version.json')?>
<?php $app_info = json_decode($app_info) ?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Aeon Project Installer</title>
        <link rel="stylesheet" href="public/assets/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="public/assets/css/material.css"> 
        <link rel="stylesheet" href="public/assets/css/material-wfont.css">
        <link rel="stylesheet" href="public/assets/css/ripples.css"> 
        <link rel="stylesheet" type="text/css" href="public/assets/css/font-awesome.css">
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
                <p id="paragraph">Press Continue to Begin Installation.</p>
                
                <input type="hidden" value="false" id="check">
                <div id="console" class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">~ root@aeon</h3>
                    </div>
                    <div id="output" class="panel-body">
                        
                    </div>
                    <div class="panel-footer">
                        <small>&copy; The Aeon Project 2015;</small>
                    </div>
                </div>
                <div id="database" class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Database Configuration (This may Take a While on Process)</h3>
                    </div>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="dbName" id="dbName" placeholder="Database Name">
                        <input type="text" class="form-control" name="dbUser" id="dbUser" placeholder="Database Username">
                        <input type="text" class="form-control" name="dbPass" id="dbPass" placeholder="Database Password">
                        <a href="#" class="btn btn-material-teal" onclick="configureDatabase()">Configure Database</a>
                    </div>
                    <div id="dbFoot" class="panel-footer">

                    </div>
                </div>
                <div id="user" class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">User Configuration</h3>
                    </div>
                    <div class="panel-body">
                        <input type="text" class="form-control" name="user" id="user" placeholder="Username">
                        <input type="text" class="form-control" name="pass" id="pass" placeholder="Password">
                        <input type="text" class="form-control" name="vpass" id="vpass" placeholder="Verify Password">
                        <a href="#" class="btn btn-material-pink" onclick="configureUser()">User Setup</a>
                    </div>
                    <div id="userFoot" class="panel-footer">
                    </div>
                </div>
                <a href="#" id="begin" class="btn btn-material-teal">Start</a>
                <a href="#" id="continue" class="btn btn-material-teal">Continue</a>
                
            </div>
            <div class="col-lg-2">
                
            </div>
    </div>
    </body>
    <script type="text/javascript" src="public/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="public/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="public/assets/js/material.js"></script>
    <script type="text/javascript" src="public/assets/js/ripples.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#database").hide();
            $("#user").hide();
            $("#continue").hide();
            $("#output").hide();
            $("#output").append("===================================================================<br />");
            $("#output").append("                   Aeon Project Installation Wizard                  ");
            $("#output").append("<br />                             -v 2.0.0                              ");
            $("#output").append("<br />===================================================================<br />");

            $("#output").append("<br /><br /> Checking System Requirements...");
            systemCheck(); 
              
            $('#begin').click(function(){
                $("#paragraph").hide();
                $("#output").show().animate();
                $("#begin").addClass("disabled");
                $("#begin").removeClass("btn-material-teal");
                $("#begin").addClass("btn-danger");
                var systemOK = $("#check").val();  
                if(systemOK == true || systemOK == "true")
                {
                    $("#output").append("<br /><br /><br />Installing Aeon Project (Standalone) This may take a minute or two... <br />");

                    $("#output").animate({
                        scrollTop: $("#output").height()
                    }, 2000);
                    commandExec("extractAeonProject");
                    $("#continue").show();
                }
                else
                {
                    $("#output").append("<br /><br /><br />You have failed (<strike>this city</strike>) to meet the system requirements. please install or update your system to meet the requirements: <br /><br />");
                }
            });

            $("#continue").click(function(){
               $("#console").hide();
               $("#continue").addClass("disabled");
               $("#database").show();
            });
        });
        
        function configureDatabase()
        {
            var dbName = $("#dbName").val();
            var dbUser = $("#dbUser").val();
            alert(dbUser);
            var dbPass = $("#dbPass").val();

            $.post('archive/configurator.php',{
                "databaseName" : dbName,
                "databaseUser" : dbUser,
                "databasePass" : dbPass
            }, function(data)
            {
                if(data == 1 || data == "1" || data == true || data == "true")
                {
                //    $("#database").hide();
                //    $("#user").show();
                    window.location = "archive/user.php";
                }
                else
                {
                    $("#dbFoot").empty();
                    $("#dbFoot").append(data);
                }
            });
        }

        function configureUser()
        {
            var user = $("#user").val();
            var pass = $("#pass").val();
            var vpass = $("#vpass").val();

            if(pass == vpass)
            {
                $.post('archive/users.php', {
                    "username" : user,
                    "password" : pass
                }, function(data)
                {
                  //  alert('ok!');
                    if(data == true)
                    {
                        alert(1);
                        window.location = "{{ public/index.php }}";   
                    }
                    else
                    {  
                        $("#userFoot").empty();
                        $("#userFoot").append(data);      
                    }
                });
            }
            else
            {
                $("#userFoot").empty();
                $("#userFoot").append("Password Mismatch");
            }
        }

        function commandProcessor()
        {
            return 'archive/cmd.php';
        }

        function commandExec(command)
        {
            $.post(commandProcessor(),
            {
                "command" : command
            },
            function(data){
                    $("#output").append(data);
                    $("#output").animate({
                        scrollTop: $("#output").height()
                    }, 2000);
            });
        }

        function composer(command)
        {
            $.post(commandProcessor(),
            {
                "command" : "command",
                "composer" : command
            },
            function(data){
                    $("#output").append(data);
            });   
        }

        function systemCheck()
        {
            $.post(commandProcessor(),
            {
                "command" : "systemCheck"
            },
            function(data){
                if(data.mcrypt == false)
                {
                    $("#output").append("<br /> Mcrypt Extension: Not Installed <br />");
                }
                else
                {
                    $("#output").append("<br /> Mcrypt Extension: Installed <br />");
                }
      
                if(data.openssl == false)
                {
                    $("#output").append(" OpenSSL Extension: Not Installed <br />");
                }
                else
                {
                    $("#output").append(" OpenSSL Extension: Installed <br />");
                }

                if(data.php5 == false)
                {
                    $("#output").append(" PHP version 5.4 or later: False <br />");
                }
                else
                {
                    $("#output").append(" PHP version 5.4 or later: OK <br />");
                }
                return $("#check").val(data.stats);
            });
        }

    </script>
</html>