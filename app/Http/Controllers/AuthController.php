<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Mail\OtpMail;
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
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'agency_name' => 'required|string|max:255',
            'business_registration_number' => 'required|string|max:255',
            'role_name' => 'required|string|max:255',
            'is_terms_and_condition_accepted' => 'required|boolean',
            'bdm_officer_id' => 'nullable|exists:business_development_officers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'agency_name' => $request->agency_name,
            'business_registration_number' => $request->business_registration_number,
            'role_name' => $request->role_name,
            'is_terms_and_condition_accepted' => $request->is_terms_and_condition_accepted,
            'bdm_officer_id' => $request->bdm_officer_id,
            'is_active' => true,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
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
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = auth()->user();

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful'
        ]);
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
        $check_token = OTP::where('email', $resetPasswordRequest->email)
            ->where('token', $resetPasswordRequest->token)
            ->first();

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

        $user = User::where('email', $resetPasswordRequest->email)->first();

        if (Hash::check($resetPasswordRequest->password, $user->password)) {
            return $this->respondBadRequest(message: 'New password cannot be the same as the old password');
        }

        $user->update([
            'password' => $resetPasswordRequest->password
        ]);

        $check_token->delete();

        return $this->respondSuccess(message: 'Password reset successfully');
    }

    public function otp(ResetPasswordRequest $resetPasswordRequest)
    {
        $expires_at = now()->addMinutes(10);
        $otp = rand(100000, 999999);

        $user = User::where('email', $resetPasswordRequest->email)->first();
        $user_full_name = $user->first_name . ' ' . $user->last_name;

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
}
