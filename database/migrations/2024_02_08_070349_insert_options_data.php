<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertOptionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('options')->insert([
            ['option' => 'Email', 'tags' => 'Communication'],
            ['option' => 'Phone', 'tags' => 'Communication'],
            ['option' => 'In-person', 'tags' => 'Communication'],
            ['option' => 'Chat', 'tags' => 'Communication'],
            ['option' => 'Video call', 'tags' => 'Communication'],
            ['option' => 'Facebook', 'tags' => 'Social Media'],
            ['option' => 'Instagram', 'tags' => 'Social Media'],
            ['option' => 'Twitter', 'tags' => 'Social Media'],
            ['option' => 'LinkedIn', 'tags' => 'Social Media'],
            ['option' => 'TikTok', 'tags' => 'Social Media'],
            ['option' => 'Pop', 'tags' => 'Music'],
            ['option' => 'Rock', 'tags' => 'Music'],
            ['option' => 'Hip-hop', 'tags' => 'Music'],
            ['option' => 'Classical', 'tags' => 'Music'],
            ['option' => 'Country', 'tags' => 'Music'],
            ['option' => 'Python', 'tags' => 'Programming'],
            ['option' => 'JavaScript', 'tags' => 'Programming'],
            ['option' => 'Java', 'tags' => 'Programming'],
            ['option' => 'C#', 'tags' => 'Programming'],
            ['option' => 'Ruby', 'tags' => 'Programming'],
            ['option' => 'Daily', 'tags' => 'Frequency'],
            ['option' => '3-4 times a week', 'tags' => 'Frequency'],
            ['option' => '1-2 times a week', 'tags' => 'Frequency'],
            ['option' => 'Rarely', 'tags' => 'Frequency'],
            ['option' => 'Never', 'tags' => 'Frequency'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
