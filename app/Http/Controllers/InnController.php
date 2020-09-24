<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InnService;
use Cache;

class InnController extends Controller
{
    public function showForm()
    {
        return view('inn-form');
    }

    public function checkInn($inn)
    {
        if (InnService::validation($inn) !== true) {
            return [
                'error' => true,
                'code' => 'validation.failed',
                'message' => 'Указан некорректный ИНН',
            ];
        }

        $key = 'inn_' . $inn;
        $inn_status = Cache::get($key);
        if (is_null($inn_status)) {
            $inn_status = InnService::checkInn($inn);
            if (!$inn_status['error']) {
                Cache::put($key, $inn_status, 86400);
            }
        }

        return (array)$inn_status;
    }
}
