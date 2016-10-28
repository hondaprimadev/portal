<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingAgendaHistory extends Model
{
    protected $fillable = ['agenda_id', 'notes'];

    public function agenda()
    {
    	return $this->belongsTo('App\MarketingAgenda', 'agenda_id', 'agenda_id');
    }
}
