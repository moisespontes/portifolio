<?php

use Phinx\Migration\AbstractMigration;

final class CreateSkillsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('skills', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('name', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('icon', 'string', ['limit' => 120, 'null' => false])
            ->addTimestamps()
            ->create();
    }
}
