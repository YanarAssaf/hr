<?php

namespace App\Http\Controllers;

use DatePeriod;
use DateInterval ;

use Illuminate\Http\Request;
use App\Leave;
use App\User;
use Auth;
use App\Department;
use Carbon\Carbon;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;



class LeavesController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $balance = $this->getUserBalance($user);
        $leaves = $user->leaves;
        return view('leaves.index', compact('user','balance','leaves'));
    }

    public function pending()
    {
        $dept= Department::find(Auth::user()->department_id);
        $users_id = $dept->users->pluck('id');
        $managers_id = User::where('is_manager', '=', '1')->pluck('id');
        if ($dept->name == 'HR') {
            $leaves = Leave::whereIn('user_id', $managers_id)->orWhereIn('user_id',$users_id)->pending()->latest()->get();
            return view('leaves.pending')->with('leaves', $leaves);
        } else {
            $leaves = Leave::whereIn('user_id', $users_id)->where('user_id', '!=', Auth::user()->id)->pending()->latest()->get();
            return view('leaves.pending')->with('leaves', $leaves);
        }
    }

    public function list()
    {
        $dept= Department::find(Auth::user()->department_id);
        $users_id = $dept->users->pluck('id');
        if ($dept->name == 'HR') {
            $leaves = Leave::where('status', '!=', '7')->latest()->get();
            return view('leaves.list')->with('leaves', $leaves);
        } else {
            $leaves = Leave::whereIn('user_id', $users_id)->where('status', '!=', '2')->latest()->get();
            return view('leaves.list')->with('leaves', $leaves);
        }
    }

    public function store(Request $request)
    {
        $user=User::find(Auth::user()->id);
        $startDate = Carbon::parse(request('start'));
        $endDate = Carbon::parse(request('end'));
        $year = $startDate->year;

        if ($startDate > $endDate) {
            toastr()->error('End Date can not be before Start Date.', 'Error!');
            return back();
        }

        $user_leaves = $user->leaves()->where(function($query) use($startDate, $endDate, $user) {
			$query->whereDate('start', '<=', $startDate)->whereDate('end', '>=', $startDate)->whereUser_id($user->id);
		})->orWhere(function($query) use($startDate, $endDate, $user) {
			$query->whereDate('start', '<=', $endDate)->whereDate('end', '>=', $endDate)->whereUser_id($user->id);
		})->orWhere(function($query) use($startDate, $endDate, $user) {
			$query->whereDate('start', '>=', $startDate)->whereDate('start', '<=', $endDate)->whereUser_id($user->id);
		})->orWhere(function($query) use($startDate, $endDate, $user) {
			$query->whereDate('end', '>=', $startDate)->whereDate('end', '<=', $endDate)->whereUser_id($user->id);
		})->get()->toArray();
       
        if (!empty($user_leaves)) {
            toastr()->error('This Date is Already in Use.', 'Error!');
            return back();
        }
        
        $leaveDuration = $this->getLeaveDuration($startDate,$endDate,$request->type);
        $userBalance = $this->getUserBalance($user) + $leaveDuration;

        if (request('type') == '0') {
            $start = Carbon::parse(request('start'));
            $end = Carbon::parse(request('end'));
            $request->merge(['start' => $start->format('Y-m-d')]);
            $request->merge(['end' => $end->format('Y-m-d')]);
        }
        
        if ($userBalance <= $user->balance->days *8 && $year == $user->balance->year) {
            $leave = Leave::create($this->validateRequest());
            if($user->is_manager){
                Mail::to(env('MAIL_HR_ADDRESS'))->send(new SendMail($leave));
            }else{
                $user = User::Where('is_manager','1')->where('department_id',$user->department_id)->first();
                Mail::to($user->email)->send(new SendMail($leave));
            }
            return back();
        } else {
            return back()->with('error', 'Your Balance Is Zero');
        }
    }

    public function report()
    {
        if (!request('id')) {
            $user = User::find(Auth::user()->id);
        }else{
            $user = User::where('name', 'like', '%'.request('id').'%')->first();
        }

        if(!$user){
            return back()->with('error', 'Result Not Found');
        }

        if (!request('mm')) {
            $leaves = $user->leaves()->latest()->get();
        }else{
            $leaves = $user->leaves()->whereMonth('start', '=', request('mm'))->latest()->get();
        }
		
		if (!request('id')) {
            $leaves = Leave::whereMonth('start', '=', request('mm'))->latest()->get();
        }

        $balance = $this->getUserBalance($user);
        return view('leaves.report', compact('user', 'leaves', 'balance'));
    }

    public function accept(Leave $leave)
    {
        $leave->update(array('status' => '1'));
        Mail::to($leave->user->email)->send(new SendMail($leave));
        return redirect('pending');
    }

    public function reject(Leave $leave)
    {
        $leave->update(array('status' => '0'));
        Mail::to($leave->user->email)->send(new SendMail($leave));
        return redirect('pending');
    }

    private function validateRequest()
    {
        return request()->validate([
            'start' => 'required',
            'end' => 'required',
            'status' => '',
            'type' => 'required',
            'user_id' => 'required'
        ]);
    }

    private function getLeaveDuration($startDate,$endDate,$type){
      
		$days = 0;
        if ($type == '0') {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $end->modify('+1 day');
        $interval = $end->diff($start);
        $days = $interval->days;
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $holidays = array('2019-12-25');
        foreach($period as $dt) {
            $curr = $dt->format('D');
            if ($curr == 'Sat' || $curr == 'Fri') {
                $days--;
            }
            elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                $days--;
            }
        }
    }
        $balance = ($days * 8);
        return $balance;
    }

    private function getUserhourlyBalance($userId){
        $hours = 0 ;
        $hourly_leaves = Leave::whereUser_id($userId)->hourly()->where('status', '!=', '0')->get();
        foreach ($hourly_leaves as $leave) {
            $startTime = Carbon::parse($leave->start);
            $endTime = Carbon::parse($leave->end);
            $diff = $endTime->diffInHours($startTime);
            $hours += $diff ;
        }
        $balance = $hours;
        return $balance;
    }

    private function getUserBalance($user){
        $daily_leaves =  Leave::whereUser_id($user->id)->paid()->where('status', '!=', '0')->whereYear('start', '=', $user->balance->year)->get() ;
        $balance = 0 ;
        foreach ($daily_leaves as $leave) {
            $balance += $this->getLeaveDuration($leave->start,$leave->end,0) ;
        }
        $balance += $this->getUserhourlyBalance($user->id);
        return $balance ;
    }

}