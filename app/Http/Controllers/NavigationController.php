<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    public function index(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('index');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function sqli_home(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('sqli_home');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function in_band(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('in_band');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function blind(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('blind');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function oob(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('oob');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function sqli_prevention(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('sqli_prevention');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function in_band_front_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('in_band_front_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function in_band_back_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('in_band_back_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function blind_front_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('blind_front_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function blind_back_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('blind_back_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function blind_time_front_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('blind_time_front_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function blind_time_back_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('blind_time_back_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function sql_validate(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('sql_validate');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function prepared(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('prepared');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function sql_secure_front_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('sql_secure_front_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }

    public function sql_secure_back_end(Request $request) {

        $name = $request->session()->get('db');

        if (isset($name)){


            return redirect()->route('sql_secure_back_end');

        } else {

            Auth::guard('web')->logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        }
    }
}
