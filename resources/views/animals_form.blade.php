@extends('layout')

@section('title', 'Update ' .$user->name.'\'s animals info')

@section('content')
    @if ($user->getAnimal())
        <a type="button" class="btn btn-info" href="{{route('users.index')}}">Back to users</a>

        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Animal name</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user->getAnimal() as $animal)
                <tr>
                    <th scope="row">{{$animal->id}}</th>
                    <td>
                        <a>{{$animal->animal_name}}</a>
                    </td>
                    <td>
                        <form method="POST" action="{{route('users.animal.destroy', ['animal' => $animal->id, 'user' => $user->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>

                </tr>
            @endforeach

            </tbody>
        </table>
    @endif

    <form method="POST"
          action="{{route('users.store.animals', ['user' => $user->id])}}">
        @csrf

        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input name="animal_name"
               type="text" class="form-control" placeholder="New animal's name" aria-label="animal_name">
        @error('animal_name')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <button type="submit" class="btn btn-success mt-2">Add animal</button>
    </form>

@endsection
