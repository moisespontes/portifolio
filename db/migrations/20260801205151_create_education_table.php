<?php

use Phinx\Migration\AbstractMigration;

final class CreateEducationTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('education', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('institution', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('course', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('level', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('icon', 'string', ['limit' => 120, 'null' => true])
            ->addColumn('start_year', 'year', ['null' => false])
            ->addColumn('end_year', 'year', ['null' => false])
            ->addTimestamps()
            ->create();
    }
}
