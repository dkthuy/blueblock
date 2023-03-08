<?php

namespace Mrthat1996\KleeBugsReport\Listeners;

use Illuminate\Support\Facades\Http;

class KleeBugsReportListener
{
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        if (in_array($event->level, explode(",", config('klee_bugs_report.log_level')))
            && in_array(config('app.env'), explode(",", config('klee_bugs_report.log_env')))) {
            try {
                Http::withHeaders(['klee-auth' => config('klee_bugs_report.token')])
                    ->post(config('klee_bugs_report.endpoint'), [
                        'message' => "{$event->context['exception']->getFile()}:{$event->context['exception']->getLine()} {$event->context['exception']->getMessage()}",
                        'data'    => json_encode($event->context['exception']->getTrace()),
                        'env'     => config('app.env')
                    ]);
            } catch (\Exception $e) {

            }
        }
    }
}