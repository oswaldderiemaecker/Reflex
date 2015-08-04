<?php

namespace Reflex\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Reflex\Http\Requests;
use Reflex\Jobs\OpenCycle;

class ProcessController extends Controller
{

    /**
     * @param $company_id
     * @return mixed
     */
    public function open_cycle($company_id)
    {
        $job = (new OpenCycle($company_id))->delay(10);

        $this->dispatch($job);

        return Redirect::to('backend/home');


    }

}
