<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Events\AdminRegistered;

use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

use App\Admin;
use Illuminate\Support\Facades\Auth;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';



    public function show(Request $request)
    {
//        dd($request->user('admin'));
        return $request->user('admin')->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('admin.verify');
    }

    public function verify(Request $request)
    {
        if ($request->route('id') != $request->user('admin')->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user('admin')->markEmailAsVerified('admin')) {
            event(new Verified($request->user('admin')));
        }

        return redirect($this->redirectPath())->with('adminVerified', true);
    }


    public function resend(Request $request)
    {
        if ($request->user('admin')->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user('admin')->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }



    public function __construct()
    {

        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function guard(){
        return Auth::guard('admin');
    }




}
