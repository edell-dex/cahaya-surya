<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    // Dashboard super admin
    public function index()
    {
        $admins = User::where('id', '!=', auth()->id())->latest()->get();

        $stats = [
            'total_admin'  => User::where('role', 'admin')->count(),
            'admin_aktif'  => User::where('role', 'admin')->where('status', 'aktif')->count(),
            'admin_nonaktif' => User::where('role', 'admin')->where('status', 'nonaktif')->count(),
            'total_pasien' => Pasien::count(),
        ];

        return view('superadmin.index', compact('admins', 'stats'));
    }

    // Form tambah admin
    public function create()
    {
        return view('superadmin.tambah');
    }

    // Simpan admin baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,superadmin',
            'status'   => 'required|in:aktif,nonaktif',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'role.required'      => 'Role wajib dipilih.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'role'     => $request->role,
            'status'   => $request->status,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('superadmin.index')
                         ->with('success', 'Akun admin baru berhasil dibuat.');
    }

    // Form edit admin
    public function edit(User $user)
    {
        return view('superadmin.edit', compact('user'));
    }

    // Update admin
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'no_hp'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,superadmin',
            'status'   => 'required|in:aktif,nonaktif',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'role'   => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.index')
                         ->with('success', 'Akun admin berhasil diperbarui.');
    }

    // Hapus admin
    public function destroy(User $user)
    {
        // Tidak bisa hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('superadmin.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Tidak bisa hapus superadmin terakhir
        if ($user->role === 'superadmin' && User::where('role', 'superadmin')->count() <= 1) {
            return redirect()->route('superadmin.index')
                             ->with('error', 'Tidak dapat menghapus satu-satunya Super Admin.');
        }

        $user->delete();

        return redirect()->route('superadmin.index')
                         ->with('success', 'Akun admin berhasil dihapus.');
    }

    // Toggle status cepat
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat mengubah status akun sendiri.');
        }

        $user->update(['status' => $user->status === 'aktif' ? 'nonaktif' : 'aktif']);

        return back()->with('success', 'Status akun berhasil diubah.');
    }
}
