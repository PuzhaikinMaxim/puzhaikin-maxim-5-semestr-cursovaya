<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyinteger('role_id')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        /*DB::table('users')->insert(
            array(
                'id' => 2,
                'name' => 'Иванова Светлана Игоревна',
                'email' => 'ivanovaSI@gmail.com',
                'password' => 'ivanovaWordPass',
                'role_id' => 2,
            )
        );
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
