<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Ship;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class ShipController extends Controller
{

    use FileUploadTrait;
    public function index()
    {
        if (! \Gate::allows('ships_manage')) {
            return abort(401);
        }

        $ships = Ship::all();

        return view('admin.ships.index', compact('ships'));
    }
    public function create()
    {
        if (! \Gate::allows('ships_manage')) {
            return abort(401);
        }
        $ships = Ship::all();
        $users = User::get()->pluck('name', 'id');

        return view('admin.ships.create', compact('ships','users'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! \Gate::allows('ships_manage')) {
            return abort(401);
        }

        $ship = Ship::create($request->all());
        $file = $this->saveFiles($request);

        $users = collect($request->users)->map(function ($user_id) {
            return User::find($user_id);
        });

        $ship->user()->saveMany($users);
        $ship->update(['file'=> $file->file]);


        return redirect()->route('admin.ships.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! \Gate::allows('users_manage')) {
            return abort(401);
        }

        $ship = Ship::findOrFail($id);
        $users = User::get()->pluck('name', 'name');

        return view('admin.ships.edit', compact('ship', 'users'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! \Gate::allows('ships_manage')) {
            return abort(401);
        }

        $ship = Ship::findOrFail($id);
        $file = $this->saveFiles($request);
        $ship->update($request->all());
        $users = collect($request->users)->map(function ($user) {
            return User::where('name', $user)->get();
        });

        $ship->update(['file'=> $file->file]);
        //@@todo associate users to ship
//        $ship->user()->saveMany($users);



        return redirect()->route('admin.ships.index');
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! \Gate::allows('ships_manage')) {
            return abort(401);
        }
        $ship = Ship::findOrFail($id);
        $ship->delete();

        return redirect()->route('admin.ships.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! \Gate::allows('ships_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
