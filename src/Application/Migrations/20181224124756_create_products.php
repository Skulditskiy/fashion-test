<?php

use Phinx\Migration\AbstractMigration;

class CreateProducts extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('products', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'string', ['limit' => 36])
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('brand', 'string', ['limit' => 255])
            ->addColumn('price_amount', 'integer', [])
            ->addColumn('price_currency', 'string', ['limit' => 3])
            ->addColumn('stock', 'integer', [])
            ->create();
    }
}
