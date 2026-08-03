<?php

use Phinx\Migration\AbstractMigration;

final class CreateTechnologiesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('technologies', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('name', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('icon', 'string', ['limit' => 120, 'null' => true])
            ->addColumn('color', 'string', ['limit' => 25, 'null' => true])
            ->addColumn('skill_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('level', 'integer', ['limit' => 3, 'default' => 0, 'null' => false])
            ->addTimestamps()
            ->addIndex(['skill_id'], ['unique' => true, 'name' => 'skill_id_UNIQUE'])
            ->addForeignKey('skill_id', 'skills', 'id', [
                'delete'     => 'SET_NULL',
                'update'     => 'NO_ACTION',
                'constraint' => 'fk_technology_skill',
            ])->create();
    }
}
