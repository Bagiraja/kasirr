<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Mengarahkan pengguna berdasarkan peran
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'pengguna':
                    return redirect()->route('pengguna.dashboard');
                case 'petugas_kasir':
                    return redirect()->route('kasir.dashboard');
                case 'petugas_barang':
                    return redirect()->route('barang.dashboard');
                default:
                    return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.', 
        ]);
    }

    // Tampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Set role default menjadi 'pengguna'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengguna',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Proses update profil
   
    
    public function showProfile()
    {
        return view('admin.profile.index', ['user' => Auth::user()]);
    }
    
    public function updateProfile(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update basic info
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
          
        ];

        // Handle password update
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok']);
            }
            $updateData['password'] = Hash::make($request->new_password);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::exists('public/profile_pictures/' . $user->profile_picture)) {
                Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }

            // Store new profile picture
            $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
            $request->file('profile_picture')->storeAs('public/profile_pictures', $fileName);
            $updateData['profile_picture'] = $fileName;
        }

        // Update the user
        User::where('id', $userId)->update($updateData);

        return back()->with('success', 'Profil berhasil diperbarui');
    }
    
}
