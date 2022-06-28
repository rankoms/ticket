<?php

use App\Models\AccountAccount;
use Illuminate\Support\Facades\DB;

function areActiveRoutes(array $routes, $output = "active-link")
{
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) return $output;
    }
}
function headersToArray($str)
{
    $headers = array();
    $headersTmpArray = explode("\r\n", $str);
    for ($i = 0; $i < count($headersTmpArray); ++$i) {
        // we dont care about the two \r\n lines at the end of the headers
        if (strlen($headersTmpArray[$i]) > 0) {
            // the headers start with HTTP status codes, which do not contain a colon so we can filter them out too
            if (strpos($headersTmpArray[$i], ":")) {
                $headerName = substr($headersTmpArray[$i], 0, strpos($headersTmpArray[$i], ":"));
                $headerValue = substr($headersTmpArray[$i], strpos($headersTmpArray[$i], ":") + 1);
                $headers[$headerName] = $headerValue;
            }
        }
    }
    return $headers;
}

function number_account_account($code){
    $account_account = AccountAccount::where('code', 'like', $code.'%')
                                    ->where(DB::raw('length(code)'), '=', 18)
                                    ->get();
    $account_account = count($account_account);
    $next_account_account = $account_account+ 1;
    $nomer = '';
    for ($i = strlen($next_account_account); $i < 3; $i++) {
        $nomer .= '0';
    }
    $format_nomer = $code .'.'. $nomer.$next_account_account;
    return $format_nomer;
}