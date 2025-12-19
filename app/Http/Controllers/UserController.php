<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display list of users.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show form create user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Save new user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,customer',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photo'), $photoPath);
        }

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }


    /**
     * Show form edit user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'role'  => 'required|in:admin,customer',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->password) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            // hapus foto lama (opsional tapi beradab)
            if ($user->photo_path && file_exists(public_path('photo/' . $user->photo_path))) {
                unlink(public_path('photo/' . $user->photo_path));
            }

            $photoPath = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photo'), $photoPath);

            $data['photo_path'] = $photoPath;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    // =========================================================
    // =============== AUTH SECTION ============================
    // =========================================================

    /**
     * Show login page.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    /**
     * Show register page.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Register new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Show profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.users.profile', compact('user'));
    }

    /**
     * Update profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Update password (jika diisi)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update photo
        if ($request->hasFile('photo')) {

            // hapus foto lama
            if ($user->photo_path && file_exists(public_path('photo/' . $user->photo_path))) {
                unlink(public_path('photo/' . $user->photo_path));
            }

            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('photo'), $photoName);

            $data['photo_path'] = $photoName;
        }

        $user->update($data);


        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
