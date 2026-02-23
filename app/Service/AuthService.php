<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;

class AuthService
{
    public function register(array $data)
    {


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // User model handles hashing via mutator
            'phone' => $data['phone'] ?? '',
            'role' => $data['role'] ?? 'user',
        ]);

        // تحديث رمز الـ FCM إذا تم إرساله
        if (!empty($data['fcm_token'])) {
            app(\App\Service\NotificationService::class)->updateFcmToken($user, $data['fcm_token'], $data['device_id'] ?? null);
        }

        \event(new Registered($user));

        // Note: Real_estate doesn't generate token on register if verification is required.
        // We will return the user object, and let the controller decide response format.

        return [
            'user' => $user,
            'requires_verification' => true
        ];
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [\__('messages.Invalid credentials')],
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => [\__('messages.Your email address is not verified')],
            ]);
        }

        // تحديث الـ FCM Token عند كل عملية دخول لضمان صحته
        // تحديث رمز الـ FCM إذا تم إرساله عند الدخول
        if (isset($data['fcm_token'])) {
            app(\App\Service\NotificationService::class)->updateFcmToken($user, $data['fcm_token'], $data['device_id'] ?? null);
        }

        return $this->generateTokenResponse($user);
    }

    public function logout(User $user)
    {
        $user->currentAccessToken()->delete();
    }

    public function logoutAll(User $user)
    {
        $user->tokens()->delete();
    }

    public function updateProfile(User $user, array $data)
    {
        // Filter out empty or null values
        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        // Ensure email is not updated via this method (usually handled separately)
        unset($data['email']);

        if (isset($data['image'])) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $data['image']->store('users', 'public');
        }

        if (isset($data['password'])) {
            // Verify current password
            if (!isset($data['current_password']) || !Hash::check($data['current_password'], $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => [\__('messages.Invalid credentials')], // Or specific message
                ]);
            }
            // Password is hashed by mutator, but if passed as array to update,
            // the mutator might not be triggered if not setting attribute directly?
            // Eloquent update() calls fill() which uses setAttribute, so mutator should work.
            // But strictness varies. Real_estate hashes it manually.
            // Supermarket User model has setPasswordAttribute.
            // So passing plain text 'password' to update() will trigger the mutator.
        }

        // Remove current_password
        unset($data['current_password']);

        $user->update($data);

        return $user;
    }

    public function deleteProfile(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->tokens()->delete();

        return $user->delete();
    }


    protected function generateTokenResponse(User $user)
    {
        $token = $user->createToken('access_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
