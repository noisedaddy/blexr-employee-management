<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\FileUploadTrait;
use App\Jobs\SendEmail;
use App\Ship;
use App\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $request->merge(
            array(
                'ms_office_licence' => $request->has('ms_office_licence') ? 1 : null,
                'git_repository' => $request->has('git_repository') ? 1 : null,
                'email_access' => $request->has('email_access') ? 1 : null
            )
        );

        $user = User::create($request->all());

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
        $user->confirmation_token = $this->create_token();
        if ($user->save()) {
            //Send registration email to user
            dispatch(new SendEmail($user));
        };
        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $request->merge(
            array(
                'ms_office_licence' => $request->has('ms_office_licence') ? 1 : null,
                'git_repository' => $request->has('git_repository') ? 1 : null,
                'email_access' => $request->has('email_access') ? 1 : null
            )
        );

        $user->update($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);
        $user->save();
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
    /**
     * @return string
     */
    protected function create_token()
    {
        return Str::random(32);
//        return str_random(32);
    }

}
