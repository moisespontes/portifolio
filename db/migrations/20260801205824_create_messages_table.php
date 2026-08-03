<?php

use Phinx\Migration\AbstractMigration;

final class CreateMessagesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('messages', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('name', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('subject', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('message', 'text', ['null' => false])
            ->addColumn('ip', 'string', ['limit' => 55, 'null' => false])
            ->addColumn('readt_at', 'timestamp', ['null' => true])
            ->addColumn('created_at', 'timestamp', [
                'null'    => true,
                'default' => 'CURRENT_TIMESTAMP',
            ])->create();
    }
}
