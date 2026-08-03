<?php

use Phinx\Migration\AbstractMigration;

final class CreateSiteSettingsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('site_settings', ['id' => true, 'signed' => false]);

        $table
            ->addColumn('site_name', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('about', 'text', ['null' => false])
            ->addColumn('phone', 'string', ['limit' => 30, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('github', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('linkedin', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('whatsapp', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('cv_file', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('logo', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('favicon', 'string', ['limit' => 120, 'null' => false])
            ->addTimestamps()
            ->create();
    }
}
