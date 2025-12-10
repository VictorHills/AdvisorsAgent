<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\AdminEmail;
use App\Mail\OtpMail;
use App\Mail\WelcomeMail;
use App\Models\OTP;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register new user
    public function register(RegisterRequest $registerRequest)
    {
        $user = User::create($registerRequest->validated());

        //send email to user and admin
        $user_full_name = $user->first_name . ' ' . $user->last_name;
        Mail::to($user->email)->send(new WelcomeMail(user_full_name: $user_full_name, email: $user->email));
        Mail::to(config('app.admin_email'))->cc(config('app.counselor_email'))->send(new AdminEmail(user: $user));

        return response()->json([
            'user' => $user,
            'message' => 'Registration successful'
        ], 201);
    }

    // Login existing user
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->respondUnauthorized(message: 'Invalid Credentials');
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $data = [
            'user' => auth()->user(),
            'token' => $token,
        ];

        return $this->respondSuccessWithData(message: 'Login successful', data: $data);
    }

    // Logout user
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['user' => $user]);
        } catch (JWTException) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function restPassword(ResetPasswordRequest $resetPasswordRequest)
    {
        $field = ($resetPasswordRequest->destination === 'email') ? 'email' : 'phone';
        $check_token = OTP::where($field, $resetPasswordRequest->$field)
            ->where('token', $resetPasswordRequest->token)
            ->first();

        $user = User::where('email', $resetPasswordRequest->email)->first();
        if (!$user) {
            return $this->respondBadRequest(message: 'User not found');
        }

        if ($resetPasswordRequest->password == null) {
            return $this->respondBadRequest(message: 'Password cannot be empty');
        }

        if ($resetPasswordRequest->token == null) {
            return $this->respondBadRequest(message: 'Token cannot be empty');
        }

        if (!$check_token) {
            return $this->respondBadRequest(message: 'Invalid token');
        }

        if ($check_token->expires_at <= now()) {
            return $this->respondBadRequest(message: 'Token has expired');
        }

        if (Hash::check($resetPasswordRequest->password, $user->password)) {
            return $this->respondBadRequest(message: 'New password cannot be the same as the old password');
        }

        $user->update([
            'password' => $resetPasswordRequest->password
        ]);

        $check_token->delete();

        return $this->respondSuccess(message: 'Password reset successfully');
    }

    public function sendOtp(ResetPasswordRequest $resetPasswordRequest)
    {
        $expires_at = now()->addMinutes(10);
        $otp = rand(100000, 999999);

        $user = User::where('email', $resetPasswordRequest->email)->first();

        if ($user) {
            $user_full_name = $user->first_name . ' ' . $user->last_name;
        } else {
            $user_full_name = 'User';
        }

        $check_token = OTP::where('email', $resetPasswordRequest->email)
            ->latest()
            ->first();

        $check_token?->update([
            'expires_at' => $expires_at,
        ]);

        $check_token?->delete();

        OTP::create([
            'email' => $resetPasswordRequest->email,
            'token' => $otp,
            'expires_at' => $expires_at,
        ]);

        Mail::to($resetPasswordRequest->email)->send(new OtpMail($otp, $user_full_name));

        return $this->respondSuccess(message: 'OTP sent successfully');
    }

    public function verifyOtp(ResetPasswordRequest $resetPasswordRequest)
    {
        if ($resetPasswordRequest->token == null) {
            return $this->respondBadRequest(message: 'Token cannot be empty');
        }

        $field = ($resetPasswordRequest->destination === 'email') ? 'email' : 'phone';
        $check_token = OTP::where($field, $resetPasswordRequest->$field)
            ->where('token', $resetPasswordRequest->token)
            ->first();

        if (!$check_token) {
            return $this->respondBadRequest(message: 'Invalid token');
        }

        if ($check_token->expires_at <= now()) {
            return $this->respondBadRequest(message: 'Token has expired');
        }

        return $this->respondSuccess(message: 'OTP verified successfully');
    }
}
