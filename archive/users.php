<?php


require '../vendor/autoload.php';
require '../bootstrap/start.php';

//from stackOverflow
function recursiveRemoveDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

$app->boot();
$user = new User;
$user->username = $_POST["user"];
$user->password = Hash::make($_POST["pass"]);
$user->save();
$user->authorizeUser("owner");
$user->save();


file_put_contents('../index.php', "<?php
		header('Location: public/index.php');
	");
recursiveRemoveDirectory('../archive');
header('Location: ../index.php');