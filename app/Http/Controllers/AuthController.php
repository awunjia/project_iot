<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\LoginUser;
use App\Http\Requests\User\ForgotUser;
use App\Http\Requests\User\ResetUser;
use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\ChangePassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Repositories\UserRepo;

class AuthController extends Controller
{

    protected  $user;

    public function __construct(UserRepo $user)
    {
        $this->user = $user;
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('pages.auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('pages.auth.register');
    }

    public function showForgot()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('pages.auth.forgot');
    }

    public function postRegister(CreateUser $req)
    {
        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ];

        $this->user->createUser($data);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');

    }

    public function postLogin(LoginUser $req)
    {

        $data = [
            'email' => $req->email,
            'password' => $req->password,
        ];

        $remember = $req->has('remember');

        if (Auth::attempt($data, $remember)) {
            return redirect()->route('home');
        }
        return redirect()->back()->with('error', 'Incorrect email or password!')->withInput();

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function sendResetLink(ForgotUser $req)
    { 
        $email = $req->input('email');
        $user = $this->user->findUserByEmail($email);
    
        if (!$user) {
            return redirect()->back()->with('error', 'The email is not registered in our records!');
        }
    
        $status = Password::sendResetLink(['email' => $email]);
    
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Reset link has been sent to your email.');
        } else {  
            return back()->with('error', 'Unable to send reset link');
        }
    }
    

     public function showResetPassword(Request $request, $token)
    {
        return view('pages.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function resetPassword(ResetUser $req)
    {
        if($req->password != $req->password_confirmation)
        {
            return redirect()->back()->with('error', 'Passwords do not match!');
        }

        $status = Password::reset(
            $req->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password reset successful.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showProfile()
    {
        $data['user'] = Auth::user();
        return view('pages.profile.view', $data);
    }

    public function updateProfile(Request $req)
    {
        //dd($req->all());
        $user = Auth::user();

        if ($req->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            $path = $req->file('avatar')->store('uploads', 'public');
            $user->avatar = $path;
        }

        $user->name = $req->name;
        $user->address = $req->address;
        $user->phone = $req->phone;
        $user->gender = $req->gender;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(ChangePassword $req)
    {
        $user = Auth::user();

        if (!Hash::check($req->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect!');
        }

        $user->password = Hash::make($req->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    public function accountSettings()
    {
        return view('pages.profile.settings');
    }


}
