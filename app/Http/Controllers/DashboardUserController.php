<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Inertia\Inertia;

class DashboardUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return Inertia::render('Dashboard/Users/Index', [
            'users' => User::latest('id')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Users/Create');
    }

    public function store(UserRequest $request)
    {
        $attributes = $request->validated();

        $attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);

        return redirect('/dashboard/users')->with('message', 'User created!');
    }

    public function edit(User $user)
    {
        return Inertia::render('Dashboard/Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(User $user, UserRequest $request)
    {
        $attributes = $request->only(['name', 'email']);

        $user->update($attributes);

        return back()->with('message', 'User updated!');
    }

    public function destroy(User $user)
    {
        try {
            $user->deleteOrFail();
        } catch (\Throwable $e) {
            return back()->with('error', 'This user cannot be deleted');
        }

        return back()->with('message', 'User was deleted!');
    }
}
