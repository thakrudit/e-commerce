<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Register Controllers
    public function register()
    {
        return view('auth.register');
    }

    public function handleRegister(Request $request)
    {
        // $credentials = $request->all();
        // Log::info("Value credentials : ", $credentials);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Send email verification
        // event(new Registered($user));

        // Send the email manually
        $user->sendEmailVerificationNotification();

        Auth::guard('web')->login($user);

        return redirect()->route('verification.notice')->with('message', 'Verification email sent successful!');
    }

    public function verifyEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->role == 1) {
                return redirect()->route('admin.dashboard')->with('message', 'Admin Login successful!');
            }
            if ($request->user()->role == 2) {
                return redirect()->route('home')->with('message', 'User Login successful!');
            }
        }

        return view('auth.verify-email');
    }

    public function verifyEmailResend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->role == 1) {
                return redirect()->route('admin.dashboard')->with('message', 'Admin Login successful!');
            }
            if ($request->user()->role == 2) {
                return redirect()->route('home')->with('message', 'User Login successful!');
            }
        }

        $request->user()->sendEmailVerificationNotification(); // Resent the verification email

        return back()->with('status', 'verification-link-sent');
    }

    public function emailVerified(EmailVerificationRequest $request)
    {
        $request->fulfill(); // Marks email as verified

        if ($request->user()->role == 1) {
            return redirect()->route('admin.dashboard')->with('message', 'Your email has been verified!');
        }
        if ($request->user()->role == 2) {
            return redirect()->route('home')->with('message', 'User Login successful!');
        }

    }

    // Login Controllers
    public function login()
    {
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        $remember = $request->filled('remember');
        // Log::info("Value : ", ["remember" => $remember]);

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $authUserData = Auth::guard('web')->user();
            $request->session()->regenerate();

            // Log::info("Login Data : ", ["Data" => $authUserData]);

            if ($authUserData->role == 1) {
                return redirect()->route('admin.dashboard')->with('message', 'Admin Login successful!');
            }
            if ($authUserData->role == 2) {
                return redirect()->route('home')->with('message', 'User Login successful!');
            }

            // return response()->json([
            //     'message' => 'Login successful',
            //     'redirect' => '/dashboard',
            //     'user' => [
            //         'name' => $authUserData->name,
            //         'email' => $authUserData->email,
            //     ]
            // ], 200);
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->withInput();
        // return redirect()->route('login.form');
        // return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function passwordRequest(Request $request)
    {
        return view('auth.forgot-password');
    }

    public function passwordEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function passwordReset(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    // Logout Controllers
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
