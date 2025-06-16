<?php

namespace App\Http\Controllers\HC;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'hc')->with('employee')->get();
        return view('hc.karyawan.index', compact('users'));
    }

    public function create()
    {
        return view('hc.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:direksi,manajer,staf_bisnis,staf_support',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Employee::create([
            'user_id'  => $user->id,
        ]);

        return redirect()->route('hc.karyawan.index')->with('success', 'Akun karyawan berhasil dibuat.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('hc.karyawan.index')->with('success', 'Akun berhasil dihapus.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('hc.karyawan.edit', compact('user'));
    }
    
    public function show($id)
    {
        $user = User::with('employee.detail')->findOrFail($id);
        return view('hc.karyawan.show', compact('user'));
    }
    public function editDetail($id)
{
    $user = User::with('employee.detail')->findOrFail($id);
    return view('hc.karyawan.edit_detail', compact('user'));
}
    public function updateDetail(Request $request, $id)
    {
        $user = User::with('employee.detail')->findOrFail($id);
    
        $request->validate([
            'nip'            => 'nullable|string|max:50',
            'divisi'         => 'nullable|string|max:100',
            'jabatan'        => 'nullable|string|max:100',
            'status'         => 'required|in:Aktif,Tidak Aktif',
            'tanggal_masuk'   => 'nullable|date',
    
            'nama_lengkap'   => 'required|string|max:255',
            'nik'            => 'nullable|string|max:20',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'no_hp'          => 'nullable|string|max:20',
            'jenis_kelamin'  => 'nullable|in:Laki-laki,Perempuan',
            'agama'          => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
        ]);
    
        // Update or create employee
        $employee = $user->employee ?: new Employee(['user_id' => $user->id]);
        $employee->fill($request->only('divisi', 'nip', 'jabatan', 'status', 'tanggal_masuk'))->save();
    
        // Update or create employeeDetail
        $detail = $employee->detail ?: new \App\Models\EmployeeDetail(['employee_id' => $employee->id]);
        $detail->fill($request->only([
            'nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir',
            'alamat', 'no_hp', 'jenis_kelamin', 'agama', 'status_perkawinan'
        ]))->save();
    
        return redirect()->route('hc.karyawan.show', $user->id)->with('success', 'Data karyawan berhasil diperbarui.');
    }
    


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'role'     => 'required|in:direksi,manajer,staf_bisnis,staf_support',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name  = $request->name;
        $user->role  = $request->role;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('hc.karyawan.index')->with('success', 'Akun berhasil diperbarui.');
    }
}
