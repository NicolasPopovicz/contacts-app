<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
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
            $table->timestampTz('created_at')->default(new Expression('CURRENT_DATE'));
            $table->timestampTz('updated_at')->default(new Expression('CURRENT_DATE'));
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
