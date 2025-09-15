<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Mostrar una lista de usuarios.
     */
    public function users()
    {
        $users = User::orderBy('id', 'DESC')->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Mostrar el formulario para crear un nuevo usuario.
     */
    public function addUser()
    {
        return view('admin.user-add');
    }

    /**
     * Almacenar un nuevo usuario en la base de datos.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'utype' => ['required', Rule::in(['ADM', 'USR'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'utype' => $request->utype,
        ]);

        return redirect()->route('admin.users')->with('status', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar el formulario para editar un usuario.
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit', compact('user'));
    }

    /**
     * Actualizar el usuario en la base de datos.
     */
    public function updateUser(Request $request)
    {
        $user = User::findOrFail($request->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'mobile' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($user->id)],
            'utype' => ['required', Rule::in(['ADM', 'USR'])],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'mobile', 'utype');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('status', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        // Evitar que un administrador se elimine a sí mismo
        if (auth()->user()->id === $user->id) {
            return redirect()->route('admin.users')->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        $user->delete();

        return redirect()->route('admin.users')->with('status', 'Usuario eliminado correctamente.');
    }
}