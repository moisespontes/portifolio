<?php

use Phinx\Migration\AbstractMigration;

final class CreateProjectTechnologyTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('project_technology', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('project_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('technology_id', 'integer', ['signed' => false, 'null' => false])
            ->addForeignKey('project_id', 'projects', 'id', [
                'delete'     => 'CASCADE',
                'update'     => 'NO_ACTION',
                'constraint' => 'fk_projects_project_technology',
            ])->addForeignKey('technology_id', 'technologies', 'id', [
                'delete'     => 'CASCADE',
                'update'     => 'NO_ACTION',
                'constraint' => 'fk_technology_project_technology',
            ])->create();
    }
}
