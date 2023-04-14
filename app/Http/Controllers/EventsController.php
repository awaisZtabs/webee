<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Workshop;
use Illuminate\Support\Facades\Date;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventsController extends BaseController
{
    public function getWarmupEvents()
    {
        return Event::all();
    }

    //  TODO: complete getEventsWithWorkshops so that it returns all events including the workshops


    public function getEventsWithWorkshops()
    {
        return Event::with("workShops")->get();
    }

    // TODO: complete getFutureEventWithWorkshops so that it returns events with workshops, that have not yet started
    public function getFutureEventsWithWorkshops()
    {
        $events = Event::with(['workshops' => function ($query) {
            $query->where('start', '>', now());
        }])->get();
        $futureEvents = [];

        foreach ($events as $event) {
            if ($event->workshops->isNotEmpty()) {
                // get the start date of the event based on the first workshop
                $eventStartDate = $event->workshops->sortBy('start')->first()->start;
                if ($eventStartDate > now()) {
                    $event->workshops = $event->workshops->sortBy('start')->values();
                    $futureEvents[] = $event;
                }
            }
        }
        return $futureEvents;
    }
}
