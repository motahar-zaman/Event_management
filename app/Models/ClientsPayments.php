<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientsPayments extends Model
{
    protected $table = 'clients_payments';
    protected $primaryKey = 'id';

    public function clients()
    {
        return $this->belongsTo('App\Models\Clients', 'clients_name_id');
    }
    public function projects()
    {
        return $this->belongsTo('App\Models\Projects', 'projects_name_id');
    }
}
