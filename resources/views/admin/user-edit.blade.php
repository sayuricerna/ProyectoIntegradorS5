@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Usuario
                        <a href="{{ route('admin.users') }}" class="btn btn-danger float-end">Volver</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        
                        <div class="mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="mobile">Teléfono</label>
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
                            @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="utype">Tipo de Usuario</label>
                            <select name="utype" class="form-control">
                                <option value="USR" {{ old('utype', $user->utype) == 'USR' ? 'selected' : '' }}>Usuario</option>
                                <option value="ADM" {{ old('utype', $user->utype) == 'ADM' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @error('utype') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password">Nueva Contraseña (Dejar vacío si no quieres cambiarla)</label>
                            <input type="password" name="password" class="form-control">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection