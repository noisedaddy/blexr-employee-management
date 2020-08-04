<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Notification;
use App\Ship;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if ( \Gate::allows('notification_manage')) {

            $roles = Role::get()->pluck('name', 'id');
            $ships = Ship::get()->pluck('name', 'id');

            return view('home', compact('roles','ships'));
        }

        if ( \Gate::allows('notification_view')) {

            $role_id = \Auth::user()->roles()->get()->first()->id;
            $notifications = Notification::where('role_id', $role_id)->where('status', null)->get();
            return view('home', compact('notifications'));
        }


    }

    /**
     * Store notification submissions
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {
        if (! \Gate::allows('notification_manage')) {
            return abort(401);
        }

        $notification = new Notification();

//        $users = User::with('roles')->get();
//        $nonmembers = $users->add(function($user, $key){
//            return $user->hasRole('Sailor');
//        });
//        dd($nonmembers);

//        $user = User::whereHas("roles", function($q){ $q->where("name", "Sailor"); })->get(); users wit roles Sailor

            foreach($request->roles as $role){

                $notification->content = $request->content;
                $notification->role_id = $role;
                $notification->ship_id = null;
                $notification->status = null;
                $notification->save();
            }

        return redirect()->route('admin.home');

    }

    /**
     * Used to populate notifications view blade
     */
    public function reloadNotifications(){

        $role_id = \Auth::user()->roles()->get()->first()->id;
        $notifications = Notification::where('role_id', $role_id)->where('status', null)->orderBy('id', 'ASC')->get();

        return response()->json(['data'=> $notifications]);
    }

    /**
     * Update notification status
     * @param Request $request
     * @return mixed
     */
    public function seenNotifications(Request $request){

        $notification = Notification::findOrFail($request->id);
        $notification->update(['status'=>'1']);

        return $notification->status;
    }
}
