<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");

	error_reporting(E_ALL & ~E_NOTICE);
	ini_set('display_errors', 1);

	require(dirname(__FILE__) . '/models/helpers/log_helper.php');

	LogHelper::add('--------------------------------------------------------------------------------');
	LogHelper::add(date('Y-m-d H:i:s', time()));
	LogHelper::add('Starting up engines...');

	#$request = ($_GET['path'] == null) ? 'main' : $_GET['path'];
	$request    = null;
	$actor_name = is_null($_GET['path']) ? 'main' : $_GET['path'];
	switch ($_GET['path']) {
		case null:
			$request = 'main';
			break;
		case null:
			$request = 'user';
			break;
		case 'actors':
      $request = $_GET['path'];
      break;
		case 'actor_attributes':
			$request = $_GET['path'];
			break;
    default:
      $request = 'models';
	}

	require(dirname(__FILE__) . '/models/bos/mysql_database_connection_bo.php');

	require(dirname(__FILE__) . '/models/helpers/string_helper.php');

	require(dirname(__FILE__) . '/models/bos/actor_bo.php');
	require(dirname(__FILE__) . '/models/bos/actor_attribute_bo.php');
	require(dirname(__FILE__) . '/models/bos/model_bo.php');

	require(dirname(__FILE__) . '/models/dos/abstract_do.php');
	require(dirname(__FILE__) . '/models/dos/actor_do.php');
	require(dirname(__FILE__) . '/models/dos/actor_attribute_do.php');
	require(dirname(__FILE__) . '/models/dos/model_do.php');

	require(dirname(__FILE__) . '/models/daos/common_dao.php');
	require(dirname(__FILE__) . '/models/daos/actor_dao.php');
	require(dirname(__FILE__) . '/models/daos/actor_attribute_dao.php');
	require(dirname(__FILE__) . '/models/daos/model_dao.php');

	$actor_bo           = new ActorBo(new ActorDao((new MysqlDatabaseBo())));
	$actor_attribute_bo = new ActorAttributeBo(new ActorAttributeDao((new MysqlDatabaseBo())));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>THEWeb</title>

	<meta http-equiv="Cache-Control" content="no-store" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="/css/index.css" type="text/css" />

	<script language="JavaScript" type="text/javascript" src="/js/jquery.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="/js/index.js"></script>
</head>

<body id="main">
<div id="container">
	<h1>
		<a href="/">THEWeb</a>
		&gt;
		<a href="/<?php echo ($request == 'main') ? null : $actor_name; ?>">
			<?php echo(StringHelper::getHumanReadable($actor_name)); ?>
		</a>
	</h1>
	<hr/>

	<ul>
		<li><a href="/">Main</a></li>
		<?php
			foreach(($actor_bo->getDao()->get()) as $record) {
				echo '<li><a href="/' . StringHelper::getLink($record["name_plural"]) . '">';
				echo ucfirst($record["name_plural"]) . '</a></li>';
			}
		?>
		<li><a href="/user">User</a></li>
	</ul>
	<hr/>

	<?php
		/* ********************************************************
		 * *** Lets require files by request... *******************
		 * ********************************************************/
		LogHelper::add('Request: ' . $request);
		require(dirname(__FILE__) . '/php/' . $request . '.php');
	?>

	<br style="clear:both;" />
	<hr/>

	<?php
		LogHelper::add(date('Y-m-d H:i:s', time()));
		LogHelper::add('--------------------------------------------------------------------------------');
	?>
	<div class="log">
		<?php
			foreach(LogHelper::get() as $log_message) {
				echo($log_message);
				echo('<br/>');
			}
		?>
	</div>

</body>
</html>
