<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9_]+$/', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'device_id' => ['required', 'string', 'max:255', Rule::unique('master.device', 'device_id')],
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'device_id' => $validated['device_id'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->ensureMasterMobileUser();

            $this->createDeviceForUser($validated['device_id']);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            throw ValidationException::withMessages([
                'email' => 'Registrasi gagal. Silakan coba lagi.',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('status', 'verification-link-sent');
    }

    private function createDeviceForUser(string $deviceId): void
    {
        try {
            DB::connection('master')->table('device')->insert([
                'approval_datetime' => null,
                'approved' => 0,
                'brand_id' => null,
                'created_at' => now(),
                'deleted_at' => null,
                'device_type_id' => null,
                'last_dongle_registration_update_timestamp' => null,
                'last_dukpt_key_download_timestamp' => null,
                'merchant_id' => 125,
                'updated_at' => now(),
                'pin_ksn' => '1CDDF8D8201BEAE00000',
                'track_ksn' => 'FFEE269CDFFBE0E00000',
                'amount_ksn' => 'f6b25e257b0a20E00000',
                'general_ksn' => '7c9e7fa42db46fE00000',
                'pin_block_mk_universal' => '11ACD1BB40727138',
                'pin_block_wk_universal' => '8B8F299E7450FDC0',
                'brand' => null,
                'device_id' => $deviceId,
                'emv_ksn' => '6BD9EDDA197176E00000',
                'type' => null,
                'description' => null,
                'enc_amount_ipek' => '12d57c9bdffe78315d9b57da7360eae4',
                'enc_emv_ipek' => '12268D02FD5565B43146B625045D8438',
                'enc_general_ipek' => '46da74da4015c8552e9f77098d9e56a4',
                'enc_pin_ipek' => '4893D4C2F11575EA25E855F3D94A928C',
                'enc_track_ipek' => 'C8C19EA1F027F9C3961D8CEC8B5D7268',
                'tmk' => null,
                'type_id' => null,
            ]);
        } catch (Throwable $e) {
            report($e);

            throw ValidationException::withMessages([
                'device_id' => 'Gagal menyimpan device. Gunakan ID lain atau coba lagi.',
            ]);
        }
    }
}
