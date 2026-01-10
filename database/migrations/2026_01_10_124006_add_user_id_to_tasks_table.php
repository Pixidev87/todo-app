<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //hozzáadás user_id mező a tasks táblához
        Schema::table('tasks', function (Blueprint $table) {
            //user_id mező hozzáadása, amely idegen kulcsként hivatkozik a users táblára
            $table->foreignId('user_id')
                // az id mező után helyezkedik el
                ->after('id')
                // idegen kulcsként hivatkozik a users táblára
                ->constrained()
                // ha a felhasználó törlésre kerül, akkor a hozzá tartozó feladatok is törlődnek
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //eltávolítás user_id mező a tasks táblából
        Schema::table('tasks', function (Blueprint $table) {
            //idegen kulcs eltávolítása és a user_id mező törlése
            $table->dropForeignIdFor(User::class);
            //user_id mező törlése
            $table->dropColumn('user_id');
        });
    }
};
