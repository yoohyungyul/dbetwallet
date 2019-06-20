<?php


namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Session;
use Hash;
use DB;


class AjaxController extends Controller
{
	public function Main(Request $request)
	{
		return json_encode(
            [
                'RESULT_CODE' => "0",
                'ERROR_MSG' => '정상'
            ]
        );
	}
}