<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Log, DB, Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();
        $users = $query->paginate(20);
        return inertia('Users/Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $user = new User;
            if ($user->isValid($data)) {
                DB::beginTransaction();
                try {
                    $user->fill($data);
                    $user->password = Hash::make($data['password']);
                    $user->status = $data['status'] ?? false;
                    $user->save();

                    // Commit Transaction
                    DB::commit();
                    return redirect()->route('users.index');
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    throw ValidationException::withMessages($e->getMessage());
                }
            }
            throw ValidationException::withMessages($user->errors);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return inertia('Users/Edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($user->isValid($data)) {
                DB::beginTransaction();
                try {
                    $user->fill($data);
                    $user->status = $data['status'] ?? false;
                    $user->save();

                    // Commit Transaction
                    DB::commit();
                    return redirect()->route('users.index');
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    throw ValidationException::withMessages($e->getMessage());
                }
            }
            throw ValidationException::withMessages($user->errors);
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
