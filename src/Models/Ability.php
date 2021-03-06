<?php

namespace Rlgroup\Abilities\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $guarded = [];

    public function abilitable()
    {
        return $this->morphTo();
    }
}
