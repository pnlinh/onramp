<?php

namespace App;

use App\Completable;
use App\Completion;
use App\Module;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model implements Completable
{
    protected $guarded = ['id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function completions()
    {
        return $this->morphMany(Completion::class, 'completable');
    }
}