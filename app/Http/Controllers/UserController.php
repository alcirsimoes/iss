<?php

namespace App\Http\Controllers;

use App\User;
use App\UserAdmin;
use App\UserInterviewer;
use App\UserSupervisor;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $pass = substr(md5(rand(0,1000)), 0, 6);
        $valid ['password'] = bcrypt($pass);
        $user = User::create($valid);

        Mail::to($user)->send(new UserCreated($user, $pass));

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $valid = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,'. $user->id,
        ]);

        $user->fill($valid);
        return $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

    public function setAdmin(User $user)
    {
        if (Auth::user()->isDev)
            UserAdmin::create(['user_id' => $user->id]);

        return back();
    }

    public function unsetAdmin(User $user)
    {
        if (Auth::user()->isDev)
            $user->isAdmin()->delete();

        return back();
    }

    public function setSupervisor(User $user)
    {
        if (Auth::user()->isAdmin)
            UserSupervisor::create(['user_id' => $user->id]);

        return back();
    }

    public function unsetSupervisor(User $user)
    {
        if (Auth::user()->isAdmin)
            $user->isSupervisor()->delete();

        return back();
    }
}
