<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';

    public function clients()
    {
        return $this->belongsTo('App\Models\Clients', 'clients_name_id');
    }
}
