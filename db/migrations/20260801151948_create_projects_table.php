<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateProjectsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('projects', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('category_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => false])
            ->addColumn('slug', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('icon', 'string', ['limit' => 120, 'null' => true])
            ->addColumn('link', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('published', 'boolean', ['default' => true, 'null' => true])
            ->addColumn('order_number', 'integer', ['default' => 0, 'null' => true])
            ->addTimestamps()
            ->addIndex(['category_id'], ['unique' => true, 'name' => 'category_id_UNIQUE'])
            ->create();
    }
}
