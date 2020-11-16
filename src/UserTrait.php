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
            'Rlgroup\Abilities\Models\Ability',
            'abilitable'
        )->withPivot('meta');
    }

    public function groupAbilities()
    {
        return $this->belongsToMany(
            'Rlgroup\Abilities\Models\GroupAbility',
            'user_group_abilities',
            'user_id',
            'user_group_id'
        );
    }

    public function isCanAction($action)
    {
        if(auth()->user()){
            $authAbilities = auth()->user()->getAllAbilities()->keys()->toArray();

            if (!in_array('*', $authAbilities) && !in_array($action, $authAbilities)) {
                return  false;
            }
            return  true;
        }
        return  false;
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
