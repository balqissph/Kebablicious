<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Services\EncryptionRoom;

new #[Layout('layouts.guest')] class extends Component
{

     public LoginForm $form;

    /**
     * Handle the login request.
     */
    public function login(): void
    {
        $this->validate();

        $key = 'login-attempts:' . Str::lower($this->form->email) . '|' . request()->ip();

        // Jika sudah diblokir
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'form.email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        $user = User::where('email', $this->form->email)->first();

        if (!$user) {
            RateLimiter::hit($key, 300);
            throw ValidationException::withMessages([
                'form.email' => __('Email tidak ditemukan.'),
            ]);
        }

        try {
            $encryptor = new EncryptionRoom();
            $decryptedPassword = $encryptor->decrypt($user->password);
        } catch (\Throwable $e) {
            RateLimiter::hit($key, 300);

            throw ValidationException::withMessages([
                'form.email' => __('Terjadi kesalahan saat membaca data.'),
            ]);
        }

        // Jika password salah → error di input password
        if ($this->form->password !== $decryptedPassword) {
            RateLimiter::hit($key, 300);

            throw ValidationException::withMessages([
                'form.password' => 'Password salah.',
            ]);
        }

        // Jika berhasil login → reset limit
        RateLimiter::clear($key);

        Auth::login($user);
        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }


}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
