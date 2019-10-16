<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        // 除第一个用户之外的所有用户
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 关注除自身以外的所有用户
        $user->follow($follower_ids);

        // 其他人都来关注第一个用户
        foreach($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
