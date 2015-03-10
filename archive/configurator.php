<?php

require '../vendor/autoload.php';
require '../bootstrap/start.php';



function execute()
{
	$execute = ['migration', 'seeder'];

	foreach ($execute as $deploy) 
	{
		try
		{
			call_user_func("execute".ucfirst($deploy));	
		}
		catch(Exception $e)
		{
			die($e);
		}
		die(true);	
	}
}

function executeMigration()
{
	Artisan::call('migrate', array('--force' => true));	
}

function executeSeeder()
{
	Artisan::call('db:seed');
}


if(empty($_POST["databaseName"])) die("Database Name Cannot be Blank");
if(empty($_POST["databaseUser"])) die("Database Username Cannot be Blank");
mysql_connect('localhost', $_POST['databaseUser'], $_POST['databasePass'], $_POST['databaseName']) or die("Cannot Connect to Database");

$database['connection']= [
	'driver'    => 'mysql',
	'host'      => 'localhost',
	'database'  => $_POST["databaseName"],
	'username'  => $_POST["databaseUser"],
	'password'  => $_POST["databasePass"],
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => '',
];
$parsed = "";

foreach ($database['connection'] as $key => $value) {
				$parsed .= sprintf("			'%s' => '%s',\n", $key, $value);	
			}

$file_parse = "<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| PDO Fetch Style
	|--------------------------------------------------------------------------
	|
	| By default, database results will be returned as instances of the PHP
	| stdClass object; however, you may desire to retrieve records in an
	| array format for simplicity. Here you can tweak the fetch style.
	|
	*/

	'fetch' => PDO::FETCH_CLASS,

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work. Of course
	| you may use many connections at once using the Database library.
	|
	*/

	// use the default connection for development mode
	'default' => 'scheduler',

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => array(

		// Creates new connection Scheduler
		// this will be our Production Database
		// To Configure just change the username
		// and password to your MySQL username and
		// password
		'scheduler' => array(
".$parsed."	
		),

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => __DIR__.'/../database/production.sqlite',
			'prefix'   => '',
		),

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'aeondata',
			'username'  => 'root',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

		'pgsql' => array(
			'driver'   => 'pgsql',
			'host'     => 'localhost',
			'database' => 'forge',
			'username' => 'forge',
			'password' => '',
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		),

		'sqlsrv' => array(
			'driver'   => 'sqlsrv',
			'host'     => 'localhost',
			'database' => 'database',
			'username' => 'root',
			'password' => '',
			'prefix'   => '',
		),

	),

	/*
	|--------------------------------------------------------------------------
	| Migration Repository Table
	|--------------------------------------------------------------------------
	|
	| This table keeps track of all the migrations that have already run for
	| your application. Using this information, we can determine which of
	| the migrations on disk haven't actually been run in the database.
	|
	*/

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => array(

		'cluster' => false,

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		),

	),

);
";

file_put_contents('database.php', $file_parse) or die("Cannot Open or Create File...");

if (!copy("database.php", "../app/config/database.php")) die("failed to copy $file...\n");

//execute();
if( Artisan::call('migrate', array('--force' => true)) == 0)
{
	if( Artisan::call('db:seed', array('--force' => true)) == 0)
	{
		die(true);	
	}
	else
	{
		die("Seeding Failed.");
	}
}
else
{
	die("Cannot Migrate Files.");
}	

