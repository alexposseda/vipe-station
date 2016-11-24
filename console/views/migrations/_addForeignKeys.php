<?php foreach ($foreignKeys as $column => $fkData): ?>

        $this->addForeignKey(
            '<?= $fkData['fk'] ?>',
            $this->tableName,
            '<?= $column ?>',
            '{{%<?= $fkData['relatedTable'] ?>}}',
            '<?= $fkData['relatedColumn'] ?>',
            'CASCADE'
        );
<?php endforeach;
