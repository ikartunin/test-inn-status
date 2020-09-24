<?php

namespace App\Services;

use App\Services\RequestService;

class InnService
{
    public static function checkInn($inn) {
        $endpoint = 'https://statusnpd.nalog.ru:443/api/v1/tracker/taxpayer_status';
        $data = [
            'inn' => $inn,
            'requestDate' => date('Y-m-d'),
        ];
        $result = RequestService::request($endpoint, $data);
        $result = json_decode($result, true);
        $result = [
            'error' => isset($result['code']),
            'code' => $result['code'] ?? null,
            'status' => $result['status'] ?? null,
            'message' => $result['message'],
        ];
        return $result;
    }

    public static function validation($inn)
    {
        switch (strlen($inn)) {
            case 10:
                return self::validationTen($inn);
                break;
            case 12:
                return self::validationTwelve($inn);
                break;
            default:
                return false;
                break;
        }
    }

    private static function validationTen($inn) {
        $weight = [2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $sum = 0;
        for ($i = 0; $i < count($weight); $i++) {
            $sum += (int)$inn[$i] * $weight[$i];
        }
        $check = $sum % 11;
        if ($check > 9) {
            $check = $sum % 10;
        }
        return ($check == $inn[9]);
    }

    private static function validationTwelve($inn) {
        $weight = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $sum = 0;
        for ($i = 0; $i < count($weight); $i++) {
            $sum += (int)$inn[$i] * $weight[$i];
        }
        $check1 = $sum % 11;
        if ($check1 > 9) {
            $check1 = $sum % 10;
        }
        $weight = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $sum = 0;
        for ($i = 0; $i < count($weight); $i++) {
            $sum += (int)$inn[$i] * $weight[$i];
        }
        $check2 = $sum % 11;
        if ($check2 > 9) {
            $check2 = $sum % 10;
        }
        return ($check1 == $inn[10] && $check2 == $inn[11]);
    }
}
