<?php

use Phinx\Migration\AbstractMigration;

final class CreateVisitorsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('visitors', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('ip', 'string', ['limit' => 55, 'null' => false])
            ->addColumn('country', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('city', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('user_agent', 'text', ['null' => false])
            ->addColumn('visited_at', 'timestamp', [
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ])->create();
    }
}
