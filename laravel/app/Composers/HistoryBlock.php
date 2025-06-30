<?php

namespace App\Composers;

use Carbon\Carbon;
use Illuminate\View\View;

class HistoryBlock
{
    public function compose(View $view)
    {
        $data['foundingYear'] = 1904;
        $data['foundingDate'] = Carbon::createMidnightDate(1904, 9, 13);
        $data['years'] = (int)$data['foundingDate']->diffInYears(Carbon::today());

        $data['birthday'] = '';

        if ((Carbon::today()->isBirthday($data['foundingDate']))) {
            $data['birthday'] = 'Happy Birthday IATSE Local 118! You are '.$data['years'].
                ' years young today!';
        }

        $data['history'] = $data;

        $view->with('data', $data);
    }
}
