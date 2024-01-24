<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE OR REPLACE VIEW current_stocks AS
        SELECT p.id, COALESCE(p.quantity, 0) + COALESCE(pi.quantity, 0::bigint) - COALESCE(oi.quantity, 0::bigint) AS quantity
          FROM products p
          LEFT JOIN ( SELECT purchase_items.product_id, sum(purchase_items.quantity) AS quantity
                  FROM purchase_items
                 GROUP BY purchase_items.product_id) pi ON p.id = pi.product_id
          LEFT JOIN ( SELECT order_items.product_id, sum(order_items.quantity) AS quantity
             FROM order_items
            GROUP BY order_items.product_id) oi ON p.id = oi.product_id
         GROUP BY p.id, pi.quantity, oi.quantity;
       ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW current_stocks");
    }
};
