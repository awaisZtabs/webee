<?php


namespace App\Models;


use App\Models\Event;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    public function event()
    {
        return $this->belongsTo(Event::class, "event_id");
    }
}
