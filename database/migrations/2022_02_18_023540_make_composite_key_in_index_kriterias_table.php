<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeCompositeKeyInIndexKriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('index_kriterias', function (Blueprint $table) {
            $table->unique(['periode_awal', 'periode_akhir', 'kriteria', 'sub_kriteria'], 'periode_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('index_kriterias', function (Blueprint $table) {
            $table->dropUnique('periode_index');
        });
    }
}
