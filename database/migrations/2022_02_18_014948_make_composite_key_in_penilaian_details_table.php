<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeCompositeKeyInPenilaianDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian_details', function (Blueprint $table) {
            $table->unique(['kriteria_id', 'penilaian_id'], 'kriteria_penilaian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_details', function (Blueprint $table) {
            $table->dropUnique('kriteria_penilaian');
        });
    }
}
