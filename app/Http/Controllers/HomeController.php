<?php

namespace App\Http\Controllers;

use App\Helpers\DataFormat;
use App\Http\Requests;
use App\Jobs\SendRequestStatusEmail;
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
     * Show the application and request approval dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = \Auth::user()->roles()->get()->first()->name;
        return view('home', compact('role'));

    }

    /**
     * Store notification submissions
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {

        $content = DataFormat::formatOutput($request);

        if (! \Gate::allows('notification_manage')) {
            return abort(401);
        }

        $role = User::whereHas("roles", function($q){ $q->where("name", "administrator"); })->first();

        $notification = new Notification();
        $notification->content = $content;
        $notification->start_date = $request->start_date;
        $notification->start_hour = $request->start_time;
        $notification->end_hour = $request->end_time;
        $notification->role_id = $role->id;
        $notification->user_id = \Auth::user()->id;
        $notification->status = config('app.request_status.pending');
        $notification->save();


        return redirect()->route('admin.home');

    }

    /**
     * Reload notification datatable from admin/home route on every 3 sec
     * @return \Illuminate\Http\JsonResponse
     */
    public function reloadNotifications(){

        if (\Auth::user()->hasRole('administrator')) {
            $role_id = \Auth::user()->roles()->get()->first()->id;
            $notifications = Notification::where('role_id', $role_id)->orderBy('id', 'ASC')->get();
        } else {
            $notifications = Notification::where('user_id', \Auth::user()->id)->orderBy('id', 'ASC')->get();
        }

        return response()->json(['data'=> $notifications]);
    }

    /**
     * Update notification status via ajax call admin/home route
     * @param Request $request
     * @return mixed
     */
    public function requestStatusChange(Request $request){

        $notification = Notification::findOrFail($request->id);
        $notification->update(['status'=>$request->status]);

        if (\Auth::user()->hasRole('administrator')) {
            dispatch(new SendRequestStatusEmail($notification));
        }
        return $notification->status;
    }
}
