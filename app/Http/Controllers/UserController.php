<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Team;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return Inertia::render("Users/Index",compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Users/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $data=$request->validate([
            'name'=>"required|string",
            'password'=>"required|string|max:20|min:8",
            'email'=>"required|email"
        ]);
        $data['password'] = bcrypt($data['password'] ) ;
        
        DB::transaction(function () use($data) {
            return tap(USer::create($data),function(User $user){
                $this->createTeam($user);
                session()->put('userId', $user->id);
            })  ;
        });

        if( Session::has('userId') ){
            return redirect()->route("users.show",$request->session()->get('userId'));
        }

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $usr = User::find($id);
            return Inertia::render("Users/Show",compact('usr'));
        } catch (\Throwable $th) {
            //throw $th;
            Session::flash('error',$th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $usr = User::find($id);
            return Inertia::render("Users/Edit",compact('usr'));
        } catch (Throwable $th) {
            //throw $th;
            Session::flash('error',$th->getMessage());
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $usr = User::find($id);
            $usr->name = $request->input('name') ;
            $usr->email = $request->input('email') ;
            $usr->save();

            return Inertia::render("Users/Show",compact('usr'));
        } catch (Throwable $th) {
            //throw $th;
            Session::flash('error',$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $usr = User::find($id)->delete();
            return redirect()->route("users.index") ;
        } catch (Throwable $th) {
            //throw $th;
            Session::flash('error',$th->getMessage());
        }
        
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }

    
}
