<?php

namespace Rlgroup\Abilities\App;

use Illuminate\Database\Eloquent\Model;

class GroupAbility extends Model
{
    protected $guarded = [];

    public function abilities()
    {
        return $this->morphToMany(
            'Rlgroup\Abilities\App\Ability',
            'abilitable'
        )->withPivot('meta');
    }
}
