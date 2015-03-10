<?php

/*
*
*
*
*
*/

if(!isset($_POST['command'])) die(date('Y/m/d h:i a')." => [Error: ] You must supply command argument.");
if(!function_exists($_POST['command'])) die(date('Y/m/d h:i a')." => [Error: ] Command `{$_POST['command']}` Not Found!");
if(isset($_POST['param']))
	call_user_func($_POST['command'],$_POST['param']);
else
	call_user_func($_POST['command']);

function extractAeonProject()
{
	$app = file_get_contents('version.json');
	$app = json_decode($app);	
	$aeon = "{$app->name}-{$app->version}-build-{$app->build}.zip";
	
	$archive = new ZipArchive;
	if(!file_exists($aeon)) die(date('Y/m/d h:i a')." => {$aeon} Not Found. Please Redownload the App or Update your version.json<br />");

	if($archive->open($aeon) == TRUE)
	{
		print(date('Y/m/d h:i a')." => Extracting {$aeon}... <br />");
		$archive->extractTo('../');
		$archive->close();
		print(date('Y/m/d h:i a')." => {$aeon} Successfully Extracted. <br />");
		die(date('Y/m/d h:i a')." => Please Press Continue...");  
	}
    die(date('Y/m/d h:i a')." => {$aeon} Unsuccessfully Extracted.<br />");
}

function systemCheck()
{
	$output = array(
        'mcrypt' => (function_exists("mcrypt_encrypt") == true) ? true : false,
        'openssl' => (function_exists("openssl_encrypt") == true) ? true : false ,
        'php5' => (PHP_VERSION >= 5.4) ? true : false,
    );
    
    if($output['mcrypt'] == false || $output['php5'] == false || $output['openssl'] == false) 
    	$output['stats'] = false;
    else
	    $output['stats'] = true;

	header("Content-Type: text/json; charset=utf-8");
	echo json_encode($output);
}
