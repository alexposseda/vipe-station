<?php
    /**
     * Created by PhpStorm.
     * User: alex
     * Date: 11/23/16
     * Time: 10:34 AM
     */

    namespace console\controllers;

    use yii\console\controllers\MigrateController;

    class MmigrateController extends MigrateController{
        public $templateFile = "@console/views/migrations/migration.php";

        public $generatorTemplateFiles = [
            'create_table'    => '@console/views/migrations/createTableMigration.php',
            'drop_table'      => '@yii/views/dropTableMigration.php',
            'add_column'      => '@yii/views/addColumnMigration.php',
            'drop_column'     => '@yii/views/dropColumnMigration.php',
            'create_junction' => '@yii/views/createTableMigration.php',
        ];
    }