<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::table('tasks', function (Blueprint $table) {
        Schema::create('tasks', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('content');
            
            //外部キー制約
            $table->string('tasklist_user_id_foreign');
            //$table->foreign(外部キーを設定するカラム名)->references(参照先のカラム名)->on(参照先のテーブル名);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_user_id_foreign');
        });
    }
}
