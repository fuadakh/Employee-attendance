<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    // Register
    public function register_page() {
        return view('register');
    }

    public function register(Request $request){
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required|unique:users',
            'password'      => 'required|confirmed|min:8',
        ]);

        $user = new User;

        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password         = Hash::make($request->password);
        $user->created_at       = date('Y-m-d H:i:s');
        $user->updated_at       = NULL;
        $user->save();

        toastify()->success('Your Email is Registered!');

        return redirect()->intended(
            route('login-page')
        );
    }

    // Verified Email
    public function verified_page() {
        return view('login');
    }

    public function verified_email($token) {
        $data = [
            'is_verified' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
        ];

        $verified = VerifiedToken::where('token', $token)->first();
        if(!empty($verified)){
            if($verified->expired_at > now()) {
                User::where('email', $verified->email)->update($data);

                toastify()->success('Your Email is Verified!');

                return redirect()->intended(
                    route('login-page')
                );
            }
        }
    }

    //Login
    public function login_page() {
        return view('login');
    }

    public function login(Request $request){
        $credential = $request->validate([
            'email'         => 'required|email',
            'password'      => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        
        if(!empty($user)) {
            if(Auth::attempt($credential, $request->remember)) {
                $request->session()->regenerate();
    
                return redirect('/');
            }
            return back()->withErrors([
                'email'  => 'Email Must be Verified'
            ]);
        }
        return back()->withErrors([
            'email'  => 'Email not found'
        ]);
    }

    // Logout
    public function logout(Request $request) {
        if(Auth::user()){
            Auth::logout();

            return redirect()->intended(
                route('login_page')
            );
        }
    }

    // SSO Google
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request) {
        if ($request->error) {
            return redirect('/user-register');
        } else {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->email)->first();
            if(!$user) {
                $user = User::create([
                    'name' => $googleUser->name, 
                    'email' => $googleUser->email, 
                    'password' => Hash::make(rand(100000,999999)),
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_verified' => 1,
                    'picture' => $googleUser->avatar,
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ]);
            }
    
            Auth::login($user);
    
            return redirect()->intended(
                route('index')
            );
        }
    }

    // Fogot Password
    public function forgot_page() {
        // $date = now();
        // $end = strtotime("+3 minutes", $date);
        return view('public.forgot_pass');
    }

    public function sendMailResetPassword(Request $request) {
        $this->validate($request, [
            'email'         => 'required|email|exists:users'
        ]);

        $user = User::where('email', $request->email)->first();

        $token = Hash::make('id='.$user->id.'&email='.$user->email);

        TokenReset::insert([
            'email'         =>  $request->email,
            'token'         =>  $token,
            'expired_at'    =>  0,
            'created_at'    =>  date('Y-m-d H:i:s'),
        ]);

        $mailData = [
            'title' => 'Reset Password',
            'link' => Route('reset-password', ['token' => $token])
        ];

        $email = new SendMail($mailData);

        Mail::to($request->email)->send($email);

        return back()->with('message', 'We have e-mailed your password reset link!');

    }

    public function showResetForm($token) {
        $check = TokenReset::where('token', $token)->first();
        if($check) {
            return view('public.reset_pass' );
        } else {
            return view('public.forgot_pass');
        }
    }

    public function resetPassword(Request $request, $token) {
        $this->validate($request, [
            'email'         => 'required|unique:users',
            'password'      => 'required|confirmed|min:8',
        ]);

        $check = 
        $user = User::where('email', $request->email)->first();
    }
}
