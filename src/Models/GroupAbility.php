<?php

namespace Rlgroup\Abilities\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAbility extends Model
{
    protected $guarded = [];

    public function abilities()
    {
        return $this->morphToMany(
            'Rlgroup\Abilities\Models\Ability',
            'abilitable'
        )->withPivot('meta');
    }
}
