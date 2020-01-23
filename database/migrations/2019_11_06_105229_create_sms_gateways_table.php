<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSmsGatewaysTable
 */
class CreateSmsGatewaysTable extends Migration
{
    /**
     * @var string
     */
    protected $tableName;

    /**
     * CreateSmsGatewaysTable constructor.
     */
    public function __construct()
    {
        $this->tableName = config('sms_manager.table_name') ?: 'sms_gateways';
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(true);
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->string('class_id', 100)->unique();
            $table->integer('priority')->unique();
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
        Schema::dropIfExists($this->tableName);
    }
}
