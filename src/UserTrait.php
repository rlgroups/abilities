<?php
namespace Rlgroup\Abilities;

//use Rlgroup\Abilities\App\Ability, Rlgroup\Abilities\App\GroupAbility;

trait UserTrait {


    public function isSuperAdmin()
    {
        return $this->id == 1;
    }

    public function abilities()
    {
        return $this->morphToMany(
            'Rlgroup\Abilities\App\Ability',
            'abilitable'
        )->withPivot('meta');
    }

    public function groupAbilities()
    {
        return $this->belongsToMany(
            'Rlgroup\Abilities\App\GroupAbility',
            'user_group_abilities',
            'user_id',
            'user_group_id'
        );
    }

    public function getAllAbilities()
    {
        $user = $this->load(['groupAbilities.abilities', 'abilities']);

        return collect([
            $user->groupAbilities->pluck('abilities')->flatten(1),
            $user->abilities
        ])->flatten(1)->pluck('pivot.meta', 'controller');
    }
}
