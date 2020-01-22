<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Rlgroup\Abilities\App\Ability;
use Rlgroup\Abilities\App\GroupAbility;
use Rlgroup\Abilities\App\UserGroupAbility;

class AbilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ability::updateOrCreate( [
                'controller' => '*',
            ],[
                'name' => '*',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);

        Ability::updateOrCreate(
            [
                'controller' => 'updateUserPermissions',
            ],[
                'name' => 'Update user permissions',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );

        GroupAbility::updateOrCreate(
            [
                'id' => '1',
            ],[
                'name' => 'superAdmin',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );

        DB::table('abilitables')::updateOrCreate(
            [
                'abilitable_type' => 'Rlgroup\Abilities\App\GroupAbility',
                'abilitable_id' => '1',
                'ability_id' => '1',
            ],[
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );

        UserGroupAbility::updateOrCreate(
            [
                'user_id' => '1',
                'user_group_id' => '1',
            ],[
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );

    }
}
