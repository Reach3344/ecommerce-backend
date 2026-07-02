<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($data);
        $token = $user->createToken('customer-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();
        $token = $user->createToken('customer-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function loginWithGoogle(Request $request)
    {
        $data = $request->validate([
            'credential' => ['required_without:id_token', 'string'],
            'id_token' => ['required_without:credential', 'string'],
        ]);

        $idToken = $data['credential'] ?? $data['id_token'];

        $googleUser = $this->verifyGoogleIdToken($idToken);

        $user = User::where('google_id', $googleUser['sub'])
            ->orWhere('email', $googleUser['email'])
            ->first();

        if ($user && ! $user->google_id) {
            $user->update(['google_id' => $googleUser['sub']]);
        }

        if (! $user) {
            $user = User::create([
                'name' => $googleUser['name'] ?? $googleUser['email'],
                'email' => $googleUser['email'],
                'email_verified_at' => now(),
                'google_id' => $googleUser['sub'],
                'profile_image' => $googleUser['picture'] ?? null,
                'password' => Str::random(40),
            ]);
        }

        $token = $user->createToken('customer-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    private function verifyGoogleIdToken(string $idToken): array
    {
        $clientId = config('services.google.client_id');

        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $idToken,
        ]);

        if ($response->failed()) {
            throw ValidationException::withMessages([
                'id_token' => ['Unable to verify Google token.'],
            ]);
        }

        $payload = $response->json();

        if (! isset($payload['aud']) || $payload['aud'] !== $clientId) {
            throw ValidationException::withMessages([
                'id_token' => ['Google token audience mismatch.'],
            ]);
        }

        if (! isset($payload['iss']) || ! in_array($payload['iss'], ['accounts.google.com', 'https://accounts.google.com'], true)) {
            throw ValidationException::withMessages([
                'id_token' => ['Invalid Google token issuer.'],
            ]);
        }

        if (! isset($payload['exp']) || time() > (int) $payload['exp']) {
            throw ValidationException::withMessages([
                'id_token' => ['Google token has expired.'],
            ]);
        }

        if (! isset($payload['email']) || ! isset($payload['sub'])) {
            throw ValidationException::withMessages([
                'id_token' => ['Incomplete Google profile data.'],
            ]);
        }

        if (isset($payload['email_verified']) && $payload['email_verified'] !== 'true' && $payload['email_verified'] !== true) {
            throw ValidationException::withMessages([
                'id_token' => ['Google email address is not verified.'],
            ]);
        }

        return $payload;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out.']);
    }
}
