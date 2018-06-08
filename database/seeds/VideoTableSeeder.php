<?php

use Illuminate\Database\Seeder;
use App\Models\VideoModel;
use Illuminate\Database\Eloquent\Model;

class VideoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $videos = factory(App\Models\VideoModel::class)->times(100)->make();
        $video_array = $videos->makeVisible(['type_id'])->toArray();
        VideoModel::insert($video_array);
    }
}
