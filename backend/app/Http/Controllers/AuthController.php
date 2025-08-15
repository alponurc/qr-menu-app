<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
  public $token;
  public $twilio_sid;
  public $twilio_verify_sid;
  public $twilio;

  public function __construct() {
    $this->token = env('TWILIO_AUTH_TOKEN');
    $this->twilio_sid = env('TWILIO_ACCOUNT_SID'); // Changed from TWILIO_SID to match Twilio's standard naming
    $this->twilio_verify_sid = env('TWILIO_VERIFY_SID');
    
    if (!$this->token || !$this->twilio_sid) {
        throw new \Exception('TWILIO_AUTH_TOKEN and TWILIO_ACCOUNT_SID must be set in .env');
    }
    
    $this->twilio = new Client($this->twilio_sid, $this->token);
  }

  public function login(Request $request) {
    $email = $request->email;
    $password = $request->password;

    if ($email == null || $password == null) {
      return response()->json(['message' => 'Please fill all fields'], 409);
    }

    if (!AppUser::where('email', $email)->exists()) {
      return response()->json(['message' => 'Email does not exist'], 409);
    }

    $user = AppUser::where('email', $email)->first();

    if (!$user || !Hash::check($password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 409);
    }

    return response()->json([
      'message' => 'User signed in successfully', 'user' => $user,
    ], 200);
  }

  public function ifUserExists(Request $request) {
    $email = $request->email;
    $password = $request->password;
    $user_name = $request->userName;
    $phone_number = $request->phoneNumber;

    if ($email == null || $password == null || $user_name == null || $phone_number == null) {
      return response()->json(['message' => 'Please fill all fields'], 409);
    }

    if (AppUser::where('user_name', $user_name)->exists()) {
      return response()->json(['message' => 'User name already exists'], 409);
    }

    if (AppUser::where('email', $email)->exists()) {
      return response()->json(['message' => 'Email already exists'], 409);
    }

    $this->twilio
      ->verify
      ->v2
      ->services($this->twilio_verify_sid)
      ->verifications
      ->create($phone_number, "sms");

    if (!$this->twilio) {
      return response()->json(['message' => 'Verification code not sent'], 409);
    }

    if ($this->twilio) {
      return response()->json(['message' => 'Verification code sent successfully'], 200);
    }
  }

  public function createNewUser(Request $request) {
    $code = $request->code;
    $email = $request->email;
    $password = $request->password;
    $user_name = ucwords($request->userName);
    $phone_number = $request->phoneNumber;

    if (AppUser::where('user_name', $user_name)->exists()) {
      return response()->json(['message' => 'User name already exists'], 409);
    }

    if (AppUser::where('email', $email)->exists()) {
      return response()->json(['message' => 'Email already exists'], 409);
    }

    $verification = $this->twilio->verify->v2->services($this->twilio_verify_sid)
      ->verificationChecks
      ->create([
        "to" => $phone_number,
        "code" => $code,
      ]);

    if ($verification->valid) {
      $user = AppUser::create([
        'email' => $email,
        'password' => Hash::make($password),
        'user_name' => $user_name,
        'phone_number' => $phone_number,
      ]);

      return response()->json([
        'message' => 'User created successfully',
        'user' => $user,
      ], 200);
    }

    if (!$verification->valid) {
      return response()->json([
        'message' => 'Invalid verification code entered!',
      ], 409);
    }
  }

  public function ifEmailExists(Request $request) {
    $email = $request->email;

    if ($email == null) {
      return response()->json(['message' => 'Email is required'], 409);
    }

    if (!AppUser::where('email', $email)->exists()) {
      return response()->json(['message' => 'Email does not exist'], 409);
    }

    $verification = $this->twilio->verify->v2->services($this->twilio_verify_sid)
      ->verifications
      ->create($email, "email");

    if ($verification) {
      return response()->json(['message' => 'Verification code sent successfully'], 200);
    }

    if (!$verification) {
      return response()->json(['message' => 'Verification code not sent'], 409);
    }
  }

  public function emailConfirm(Request $request) {
    $email = $request->email;
    $code = $request->code;

    $token = env('TWILIO_AUTH_TOKEN');
    $twilio_sid = env('TWILIO_ACCOUNT_SID');
    $twilio_verify_sid = env('TWILIO_VERIFY_SID');
    
    if (!$token || !$twilio_sid) {
        throw new \Exception('TWILIO_AUTH_TOKEN and TWILIO_ACCOUNT_SID must be set in .env');
    }
    
    $twilio = new Client($twilio_sid, $token);

    $verification = $twilio->verify->v2->services($twilio_verify_sid)
      ->verificationChecks
      ->create([
        "to" => $email,
        "code" => $code,
      ]);

    if ($verification->valid) {
      return response()->json([
        'message' => 'Email confirmed successfully',
      ], 200);
    }

    if (!$verification->valid) {
      return response()->json([
        'message' => 'Invalid verification code entered!',
      ], 409);
    }
  }

  public function resetPassword(Request $request) {
    $email = $request->email;
    $password = $request->password;

    if ($email == null || $password == null) {
      return response()->json([
        'message' => 'Please fill all fields',
      ], 409);
    }

    if (!AppUser::where('email', $email)->exists()) {
      return response()->json([
        'message' => 'Email does not exist',
      ], 409);
    }

    $user = AppUser::where('email', $email)->first();

    $user->password = Hash::make($password);
    $user->save();

    return response()->json([
      'message' => 'Password reset successfully',
      'user' => $user,
    ], 200);
  }

  public function updateUser(Request $request) {
    $id = $request->id;
    $email = $request->email;
    $country = $request->country;
    $user_name = $request->userName;

    if ($email == null || $user_name == null  || $country == null) {
      return response()->json(['message' => 'Please fill all fields'], 409);
    }

    $user = AppUser::where('id', $id)->first();

    $user->email = $email;
    $user->country = $country;
    $user->user_name = $user_name;
    $user->save();

    return response()->json([
      'message' => 'User updated successfully',
      'user' => $user,
    ], 200);
  }
}
