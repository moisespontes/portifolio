<?php

use Phinx\Migration\AbstractMigration;

final class CreateExperiencesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('experiences', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('company', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('position', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['null' => false])
            ->addColumn('start_date', 'date', ['null' => false])
            ->addColumn('end_date', 'date', ['null' => true])
            ->addColumn('current_job', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('order_number', 'integer', ['default' => 0, 'null' => false])
            ->addTimestamps()
            ->create();
    }
}
