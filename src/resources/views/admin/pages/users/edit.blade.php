@extends('adminlte::page')

@section('title', config('adminlte.title') . ' - Editar Usuário')

@section('content')
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Editar dados do usuário</h3>
    </div>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="box-body">
            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
              <label for="name">Nome <span class="text-danger">*</span></label>
              <input type="text" class="{{ $errors->has('name') ? 'form-control is-invalid' : 'form-control' }}" id="name" name="name" value="{{ $user->name }}">
              @if($errors->has('name'))
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
              @endif
            </div>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
              <label for="email">E-mail<span class="text-danger">*</span></label>
              <input type="email" class="{{ $errors->has('email') ? 'form-control is-invalid' : 'form-control' }}" id="email" name="email" value="{{ $user->email }}">
              @if($errors->has('email'))
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
              @endif
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
              <label for="password">Senha</label>
              <input type="password" class="{{ $errors->has('password') ? 'form-control is-invalid' : 'form-control' }}" id="password" name="password">
              @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
              @endif
            </div>

            <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
              <label for="password_confirmation">Confirmar senha</label>
              <input type="password" class="{{ $errors->has('password_confirmation') ? 'form-control is-invalid' : 'form-control' }}" id="password_confirmation" name="password_confirmation">
              @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">
                    {{ $errors->first('password_confirmation') }}
                </div>
              @endif
            </div>
            <div class="form-group {{ ($errors->has('user_role')) ? 'has-error' : '' }}">
                <label for="user_role">Tipo de usuário <span class="text-danger">*</span></label>
                <select name="user_role" id="user_role" class="{{ $errors->has('user_role') ? 'form-control is-invalid' : 'form-control' }}">
                    <option value="0">-- Selecione --</option>
                    @foreach ($roles as $key => $role)
                    <option value="{{ $key }}" {{ $user->user_role == $key ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                    @endforeach
                </select>
                @if($errors->has('user_role'))
                  <div class="invalid-feedback">
                      {{ $errors->first('user_role') }}
                  </div>
                @endif
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Salvar</button>
        </div>
    </form>
</div>
@endsection
