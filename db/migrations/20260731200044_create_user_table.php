<?php

use Phinx\Migration\AbstractMigration;

final class CreateUserTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('first_name', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 120, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('image', 'string', ['limit' => 45, 'null' => true])
            ->addColumn('role', 'enum', [
                'values'  => ['admin', 'editor'],
                'default' => 'admin',
                'null'    => false,
            ])
            ->addColumn('last_login_at', 'timestamp', ['null' => true])
            ->addTimestamps()
            ->addIndex(['email'], ['unique' => true, 'name' => 'email_UNIQUE'])
            ->create();
    }
}
