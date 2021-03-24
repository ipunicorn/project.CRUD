@extends('layout')

@section('title', isset($user) ? 'Update '.$user->name : 'Create user')

@section('content')

    <a type="button" class="btn btn-info" href="{{route('users.index')}}">Back to users</a>
    <div class="col mt-3">
        <h3>{{isset($user) ? "About ".$user->name: ''}}</h3>
    </div>
    <form method="POST"
          @isset($user)
          action="{{route('users.update', $user)}}"
          @else
          action="{{route('users.store')}}"
          @endif
          class="mt-3">
        @csrf

        @isset($user)
            @method('PUT')
        @endisset
        <div class="row">
            <div class="col">
                <input name="name"
                       value="{{old('name', isset($user) ? $user->name : null)}}"
                       type="text" class="form-control" placeholder="Name" aria-label="name">
                @error('name')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="col mt-3">
            <input name="email"
                   value="{{old('email', isset($user) ? $user->email : null)}}"
                   type="text" class="form-control" placeholder="Email" aria-label="email">
            @error('email')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-success">{{isset($user) ? "Update" : "Create"}}</button>
            </div>
        </div>

        <div class="col mt-3">
            <div class="col mt-3">
                <h3>{{isset($user) ? "About ".$user->name."'s animals" : ''}}</h3>
            </div>

            @if (isset($user))

                @if ($user->getImplodedAnimalNames() !== '')
                    <h5>{{$user->getImplodedAnimalNames()}}</h5>

                @else
                    <h5>No animals yet</h5>
                @endif
            @endif
        </div>

        <div class="row mt-3">
            <div class="col">

                <a class="btn btn-warning" href="{{route('users.index')}}">Update animals information</a>

            </div>
        </div>
    </form>

@endsection
