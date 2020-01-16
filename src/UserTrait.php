<?php
namespace Rlgroup\Abilities;

/*use DB;
use FluidXml\FluidXml;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Exception\RequestException;*/

trait UserTrait {
    public function isSuperAdmin()
    {
        return $this->id == 1;
    }

    public function abilities()
    {
        return $this->morphToMany(
            'App\Ability',
            'abilitable'
        )->withPivot('meta');
    }

    public function groupAbilities()
    {
        return $this->belongsToMany(
            'App\GroupAbility',
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
