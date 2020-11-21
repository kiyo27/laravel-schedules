<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleUser = new User;
        $sampleUser->name = 'sample';
        $sampleUser->email = 'sample@sample.com';
        $sampleUser->password = bcrypt('r4YjKaUPCN5FsZ2');
        $sampleUser->save();
    }
}
