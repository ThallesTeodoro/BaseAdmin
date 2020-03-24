@extends('adminlte::page')

@section('title', config('adminlte.title') . ' - Usuários')

@section('content_header')
    <h1>Usuários Cadastrados</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Lista de usuários <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fa fa-fw fa-user-plus"></i> Adicionar</a></h3>
        </div>

        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    @csrf
                    <label>Search:
                        <input type="search" name="search" value="{{ request()->search ?: '' }}" class="form-control input-sm">
                    </label>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Pesquisar</button>

                    @if(!empty(request()->search))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-warning">Limpar</a>
                    @endif
                </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>E-mail</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($users) && count($users) > 0)
                      @foreach($users as $user)
                        <tr>
                          <td>{{ $user->id }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td class="text-center">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Remove</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td colspan="4" class="text-center warning">Nada encontrado!</td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @if(!empty($users) && count($users) > 0)
            <div class="row">
              <div class="col-sm-5">
                <div role="status">Página {{ $users->currentPage() }} de {{ $users->lastPage() }}</div>
              </div>
              <div class="col-sm-7">
                {{ $users->appends(request()->all())->render() }}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
</div>
@endsection
