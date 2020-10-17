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
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phonenumber')->unique();
            $table->string('imageprofile')->nullable();
            $table->string('role');
            $table->timestamp('email_verified_at')->nullable(); //hanya untuk admin
            $table->boolean('isVerified')->nullable()->default(false);
            $table->string('verifiedby')->nullable();   //verifikasi akun admin
            $table->string('status');   //status apakah masih aktif atau tidak
            $table->string('update_by')->nullable();    //siapa yang akan mengubah status user
            $table->string('deleted_by')->nullable();
            $table->timestamp('deleted_at',0)->nullable();
            $table->timestamps();
        });
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
