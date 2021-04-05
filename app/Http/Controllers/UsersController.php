<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalRequest;
use App\Http\Requests\UserRequest;
use App\Models\Animal;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $users = User::paginate(15);

        return view('index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        User::create($request->only(['name', 'email']));

        return redirect()->route('users.index')->withSuccess('Created user ' . $request->name);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View|Response
     */
    public function show(User $user)
    {
        return view('show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View|Response
     */
    public function edit(User $user)
    {
        return view('form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->only(['name', 'email']));

        return redirect()->route('users.index')->withSuccess('Updated user ' . $user->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->withDanger('Delete user ' . $user->name);
    }

    public function animals(User $user)
    {
        return view('animals_form', compact('user'));
    }

    public function animalsStore(AnimalRequest $request)
    {
        Animal::create($request->only('user_id', 'animal_name'));

        return redirect(route('users.animals', ['user' => $request->user_id]))->withSuccess($request->animal_name. ' was successfully added');
    }

    public function animalsDestroy(User $user, Animal $animal)
    {
        if (!in_array($animal->id, $user->getAnimalID())) {
            return redirect(route('users.animals', ['user' => $user->id]))->withDanger('Animal does not exist');
        }

        $animal->delete();

        return redirect(route('users.animals', ['user' => $user->id]))->withDanger('Animal was successfully deleted');
    }
}
