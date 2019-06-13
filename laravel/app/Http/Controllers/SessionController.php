<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Session;

class SessionController extends Controller
{
    public function accessSessionData(Request $request)
    {
        if ($request->session()->has('my_name')) {
            echo $request->session()->get('my_name');
        } else {
            echo 'No data in the session';
        }
    }
    public function storeSessionData(Request $request)
    {
        $request->session()->put('my_name', 'barkin');
        echo "Data has been added to session";
    }
    public function deleteSessionData(Request $request)
    {
        $request->session()->forget('my_name');
        echo "Data has been removed from session.";
    }

    public function print()
    {

        echo "<head>
                <meta http-equiv='refresh' content='1'>
              </head>";
        echo "<pre>";
        print_r(session()->all()) ;
    }

    public function fileConverted()
    {
      echo (session()->get('fileConverted'));
    }
}
