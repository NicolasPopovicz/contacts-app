<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('contacts');

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'contacts_user_id'
            );
            $table->string('name', length: 150)->nullable(false);
            $table->string('cpf', length: 11)->unique()->nullable(false);
            $table->string('phone', length: 11)->nullable(false);
            $table->string('address', length: 200)->nullable();
            $table->string('cep', length: 8)->nullable(false);
            $table->string('state', length: 2)->nullable(false);
            $table->string('latitude', length: 12)->nullable(false);
            $table->string('longitude', length: 12)->nullable(false);
            $table->timestamp('created_at', precision: 0)->nullable(false)->default(date('Y-m-d H:i:s'));
            $table->timestamp('updated_at', precision: 0)->nullable(false)->default(date('Y-m-d H:i:s'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
