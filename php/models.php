<?php
  # This should be a controller type class... maybe somewhere
  #   further down the projectline... [artidas]

  $model_bo = new ModelBo(
    $actor_name,
    $actor_bo,
    $actor_attribute_bo,
    $_POST
  );

  LogHelper::add('BEGIN Checking ModelDo parameters:');
  foreach($model_bo->getDo()->attributes as $attribute) {
    LogHelper::add('... parameter: "' . $attribute['name'] . '" is set to: ' . '"' . $model_bo->getDo()->parameters[$attribute['name']] . '"');
  };
  LogHelper::add('END Checking ModelDo parameters!');

  $actor = $model_bo->getActor();

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
		$response[] = 'Creating...';
    LogHelper::add('Processing request for record creation...');
    LogHelper::add('BEGIN $_POST:');
    foreach ($_POST as $key => $value) { LogHelper::add($key . '=>' . $value); };
    LogHelper::add('END $_POST!');
		if ($model_bo->getDao()->create($model_bo->getDo())) {
			$response[] = 'Created...';
		}
		else {
			$response[] = 'Something went wrong...';
		}
	}
	elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    LogHelper::add('Processing request for record inactivation...');
		$response[] = 'Deleting...';
		if ($model_bo->getDao()->delete([$_POST['id']])) {
			$response[] = 'Deleted...';
		}
		else {
			$response[] = 'Something went wrong...';
		}
	}

?>

<p><?php if ($response) {var_dump($response);} ?></p>


<h2>Create</h2>
<form action="" method="post">
  <?php foreach($model_bo->getActorAttributes() as $actor_attribute_record) { ?>

    <label for="<?php echo($actor_attribute_record['name']); ?>">
      <?php echo(StringHelper::getHumanReadable($actor_attribute_record['name'])); ?>
    </label>

      <?php
        switch ($actor_attribute_record['form_type']):
        case (ActorAttributeBo::VALUE_FORM_TYPE_SELECT):
      ?>
        <select
          id="<?php echo($actor_attribute_record['name']); ?>"
          name="<?php echo($actor_attribute_record['name']); ?>"
        >
          <option value="">-- SELECT --</option>
          <?php
            switch ($actor_attribute_record['form_source']):
              case (ActorAttributeBo::VALUE_FORM_SOURCE_ACTOR):
          ?>
            <?php
              foreach (
                (new ModelBo(
                  StringHelper::getActorNameFromIdActorAttributeName($actor_attribute_record['name']),
                  new ActorBo(new ActorDao((new MysqlDatabaseBo()))),
                  new ActorAttributeBo(new ActorAttributeDao((new MysqlDatabaseBo())))
                ))->getRecords() as $select_actor_record
              ) {
                echo '<option value="' . $select_actor_record['id'] . '"';
                if ($select_actor_record['id'] == $model_bo->getDo()->parameters[$actor_attribute_record['name']]) {
                  echo(' selected ');
                };
                echo '>';
                echo ucfirst($select_actor_record['name']);
                echo '</option>';
              }
            ?>
            <?php break; ?>
          <?php default: ?>
            <?php
              $select_class_name    = StringHelper::getBoNameFromActorLinkSingularName($model_bo->actor_name_singular);
              $select_variable_name = $actor_attribute_record['name'] . '_values';
              foreach ($select_class_name::$$select_variable_name as $select_option_name) {
                echo '<option value="' . $select_option_name . '"';
                if ($select_option_name == $model_bo->getDo()->parameters[$actor_attribute_record['name']]) {
                  echo(' selected ');
                };
                echo '>';
                echo $select_option_name;
                echo '</option>';
              }
            ?>
          <?php endswitch; ?>
        </select>
        <span class="description"><?php echo($actor_attribute_record['description']); ?></span>
        <?php break; ?>

        <?php case (ActorAttributeBo::VALUE_FORM_TYPE_TEXTAREA): ?>
          <textarea
            id="<?php echo($actor_attribute_record['name']); ?>"
            name="<?php echo($actor_attribute_record['name']); ?>"
          ><?php echo $model_bo->getDo()->parameters[$actor_attribute_record['name']] ?></textarea>
          <span class="description"><?php echo($actor_attribute_record['description']); ?></span>
        <?php break; ?>

      <?php default: ?>
        <input
          id="<?php echo($actor_attribute_record['name']); ?>"
          name="<?php echo($actor_attribute_record['name']); ?>"
          value="<?php echo $model_bo->getDo()->parameters[$actor_attribute_record['name']] ?>"
          type="text"
        />
        <span class="description"><?php echo($actor_attribute_record['description']); ?></span>
    <?php endswitch; ?>

    <br/>
  <?php } ?>

	<input value="Save" name="create" type="submit" class="button" />
</form>
<hr/>


<?php
  $table_helper = [];
?>
<h2>List</h2>
<table id="model_list">
	<thead>
		<tr>
      <th>id</th>
      <?php foreach($model_bo->getActorAttributes() as $actor_attribute) { ?>
        <th>
          <?php echo($actor_attribute['name']); ?>
        </th>
      <?php } ?>

      <th>is_active</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
    <?php	foreach(($model_bo->getRecords()) as $record) { ?>
      <tr>
        <td>#<?php echo($record['id']); ?></td>
        <?php foreach($model_bo->getActorAttributes() as $actor_attribute) { ?>
          <td name="<?php echo($actor_attribute['name']) ?>">
            <?php
              if ($actor_attribute['form_source'] === ActorAttributeBo::VALUE_FORM_SOURCE_ACTOR) {
                $actor_singular_name = StringHelper::getActorNameFromIdActorAttributeName($actor_attribute['name']);
                echo('(#' . $record[($actor_singular_name . '_id')] . ') ');
                echo($record[($actor_singular_name . '_name')]);
              }
              elseif ($actor_attribute['form_type'] === ActorAttributeBo::VALUE_FORM_TYPE_TEXTAREA) {
                echo(nl2br($record[$actor_attribute['name']]));
              }
              else {
                if ($actor_attribute['data_type'] === ActorAttributeBo::VALUE_DATA_TYPE_FLOAT) {
                  echo(number_format($record[$actor_attribute['name']]));
                  $table_helper['total'][$actor_attribute['name']] += $record[$actor_attribute['name']];
                }
                elseif (strpos($actor_attribute['name'], 'uom') !== false) {
                  echo($record[$actor_attribute['name']]);
                  if (
                    strpos(
                      $table_helper['total_uom'][$actor_attribute['name']],
                      $record[$actor_attribute['name']]
                    ) === false
                  ) {
                    $table_helper['total_uom'][$actor_attribute['name']] .= $record[$actor_attribute['name']];
                  }
                }
                else {
                  echo($record[$actor_attribute['name']]);
                }
              };
            ?>
          </td>
        <?php } ?>

        <td><?php echo($record['is_active']); ?></td>
        <td>
					<form action="" method="post">
						<input value="<?php echo $record['id'] ?>" name="id" type="hidden" />
						<input value="X" name="delete" type="submit" class="confirm" />
					</form>
				</td>
      </tr>
    <?php } ?>
	</tbody>

  <?php if (!empty($table_helper)) : ?>
    <tfoot>
      <tr>
        <td>&nbsp;</td>
        <?php foreach($model_bo->getActorAttributes() as $actor_attribute) : ?>
          <?php if (isset($table_helper['total'][$actor_attribute['name']])) : ?>
            <td name="total"><?php echo(number_format($table_helper['total'][$actor_attribute['name']])); ?></td>
          <?php elseif (isset($table_helper['total_uom'][$actor_attribute['name']])) : ?>
            <td name="uom"><?php echo($table_helper['total_uom'][$actor_attribute['name']]); ?></td>
          <?php else : ?>
            <td>&nbsp;</td>
          <?php endif; ?>
        <?php endforeach; ?>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tfoot>
  <?php endif; ?>

</table>
<hr/>


<script language="JavaScript" type="text/javascript" src="/js/model.js"></script>
