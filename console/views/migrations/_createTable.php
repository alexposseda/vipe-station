<?php

/**
 * Creates a call for the method `yii\db\Migration::createTable()`
 */
/* @var $table string the name table */
/* @var $fields array the fields */
/* @var $foreignKeys array the foreign keys */

?>        $this->createTable($this->tableName, [
<?php foreach ($fields as $field):
    if (empty($field['decorators'])): ?>
            '<?= $field['property'] ?>',
<?php else: ?>
            <?= "'{$field['property']}' => \$this->{$field['decorators']}" ?>,
<?php endif;
endforeach; ?>
    'created_at'           => $this->integer(),
    'updated_at'           => $this->integer(),
        ], $tableOptions);
<?= $this->render('@yii/views/_addForeignKeys', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);
