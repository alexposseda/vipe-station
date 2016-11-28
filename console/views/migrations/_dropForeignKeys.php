<?php foreach ($foreignKeys as $column => $fkData): ?>
        $this->dropForeignKey(
            '<?= $fkData['fk'] ?>',
            $this->tableName
        );


<?php endforeach;
