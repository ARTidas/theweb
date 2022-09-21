<div style="background-color:#fcc;">
	<h2>Notes</h2>
	<ul>
		<li>Item 1...</li>
		<li>Item 2...</li>
	</ul>
</div>
<hr/>

<div style="background-color:#ffc;">
	<h2>Links</h2>
	<ul>
		<li><a href="https://unithe.hu/">THE hivatalos honlapja...</a></li>
		<li><a href="https://neptun.unithe.hu/hallgato/login.aspx">THE Neptun</a></li>
	</ul>
</div>
<hr/>


<h2>Project dictionary</h2>

<h3>Actors</h3>
<ul>
	<?php
		foreach(($actor_bo->getDao()->get()) as $record) {
			echo '<li>';
			echo '<strong>' . ucfirst($record["name"]) . '</strong> - ';
			echo '(' . ucfirst($record["name_plural"]) . ') - ';
			echo $record["description"] . ' - ';
			echo '#' . $record["id"];
			echo '</li>';
		}
	?>
</ul>

<h3>Abbrevations</h3>
<ul>
	<li>UOM - Unit of Measurement</li>
	<li>FX - Foreign Currency Exchange</li>
</ul>

<!--
<?php
/* ********************************************************
 * *** How many days left *********************************
 * ********************************************************/
	$deadline_datetime = mktime(12, 00, 00, 9, 01, 2020);
	$current_datetime = time();
	$daysleft = round(((($deadline_datetime - $current_datetime) / 24) / 60) / 60);
?>
<p>
	<span style="font-size: 24px;">
		Days left: <strong><?php echo $daysleft ?></strong>
	</span>
	<br/>
	Deadline: <?php echo date('Y-m-d H:i:s', $deadline_datetime) ?>
	<br/>
	Current time: <?php echo date('Y-m-d H:i:s', $current_datetime) ?>
</p>
-->
