<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use RecordsActivity;

    protected $fillable = ['user_id'];

    public function liked()
    {
        return $this->morphTo();
    }
}