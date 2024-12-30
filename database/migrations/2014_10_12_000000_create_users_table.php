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
            $table->string('employee_no')->unique()->nullable();
            $table->string('username')->nullable();
            $table->integer('role')->nullable(); // connect to another table to get role id

            // Personal Information
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('district')->nullable();
            $table->string('postcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();

            // Company Information
            $table->string('company')->nullable();
            $table->string('designation')->nullable();
            $table->date('join_date')->nullable();
            $table->mediumText('company_address')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('avatar')->nullable();
            $table->string('signature')->nullable();
            $table->text('bank_information')->nullable();
            $table->text('mbanking_information')->nullable();
            $table->string('alternative_email')->nullable();
            $table->enum('employee_status', ['Enroll', 'Terminated', 'Long Leave', 'Left Job', 'On Hold'])->nullable();
            $table->string('employee_status_reason')->nullable();

            // Common Activity
            $table->integer('is_active')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
