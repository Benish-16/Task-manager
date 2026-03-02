<?php

namespace App\Http\Controllers;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;
use App\Models\Task;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


class AuthController extends Controller
{
 public function userlist()
{
    $tenant_id = tenant('id');

    $query = User::where('tenant_id', $tenant_id);

    if (Auth::check() && Auth::user()->hasRole('Manager')) {

        
        $query->whereHas('roles', function ($q) {
            $q->where('name', 'employee');
        });

    }

    $users = $query->paginate(9);

    return view('tenants.listuser', compact('users'));
}
public function useredit($id)
{
    $user = User::where('id', $id)
        ->where('tenant_id', tenant('id'))
        ->firstOrFail();

    app(PermissionRegistrar::class)
        ->setPermissionsTeamId(tenant('id'));

    $roles = Role::where('team_id', tenant('id'))->get();

    return view('tenants.edituser', compact('user', 'roles'));
}



     
    public function updateuser(Request $request, $id)
    {
      
        $user = User::findOrFail($id);
       
      
        $request->validate([
            'name' => 'nullable|string|max:255',
            'role' => 'nullable|string|exists:roles,name',
        ]);

      
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

  
        if ($request->filled('role')) {
            app(PermissionRegistrar::class)->setPermissionsTeamId($user->tenant_id); // optional, if multi-tenant
            $user->syncRoles([$request->role]);
        }

        $user->save();

        return redirect()->route('tenants.userlist')->with('success', 'User updated successfully.');
    }

   public function login(){
        return view('tenants.login');

      
    }


public function dashboard()
{
    $user = Auth::user();

    $totalTasks = Task::where('assigned_to', $user->id)->count();

    $pendingTasks = Task::where('assigned_to', $user->id)
        ->where('status', 'pending')
        ->count();

    $inProgressTasks = Task::where('assigned_to', $user->id)
        ->where('status', 'in_progress')
        ->count();

    $completedTasks = Task::where('assigned_to', $user->id)
        ->where('status', 'completed')
        ->count();
        $progressPercent = $totalTasks > 0
    ? round(($completedTasks / $totalTasks) * 100)
    : 0;

    return view('tenants.dashboard', compact(
        'totalTasks',
        'pendingTasks',
        'inProgressTasks',
        'completedTasks',
        'progressPercent'
    ));
}
public function viewTasks(){
    $user = Auth::user();

    $tasks = Task::where('assigned_to', $user->id)->get();

    return view('tasks.specific', compact('tasks'));
}
public function loginStore(Request $request)
{
      $tenantId = tenant('id'); 
       $userExists = User::where('email', $request->email)
                      ->where('tenant_id', $tenantId)
                      ->exists();

    if (! $userExists) {
        return back()->withErrors([
            'email' => 'This email does not belong to this tenant.',
        ])->withInput();
    }

    app(PermissionRegistrar::class)
        ->setPermissionsTeamId(tenant('id'));

    $credentials = [
        'email'     => $request->email,
        'password'  => $request->password,
        'tenant_id' => tenant('id'),
    ];
    

    if (Auth::guard('web')->attempt($credentials)) {
        $user = Auth::guard('web')->user(); 
        Auth::guard('web')->login($user); 

        $request->session()->regenerate();

        return redirect()->route('tenants.dashboard');
    }
    return back()->withErrors([
        'email' => 'Invalid credentials',
    ]);
}
   public function register(){
     app(PermissionRegistrar::class)
        ->setPermissionsTeamId(tenant('id'));

    $roles = Role::where('team_id', tenant('id'))->get();
        return view('tenants.register',compact('roles'));

    }
    public function registerStore(Request $request){

         $tenant_id = tenant('id');
      $request->validate([
        'name'=>'required|String|max:255',
                'email'=>'required|String|email|max:255',
                        'password'=>'required|String|min:6|confirmed',
                           Rule::unique('users')->where(function ($query) use ($tenant_id) {
                    return $query->where('tenant_id', $tenant_id);
                }),
            
      ]);
    $user=  User::create([
'name'=>$request->name,
'email'=>$request->email,

                 'tenant_id' => $tenant_id, 
            
'password'=>bcrypt($request->password),
      ]);
       if ($request->filled('role')) {
            app(PermissionRegistrar::class)->setPermissionsTeamId($user->tenant_id); 
            $user->syncRoles([$request->role]);
        }
        $user->save();

      return redirect()->route('tenants.login')->with('success','Registration successfull,please login');
    }
   public function logout(Request $request)
{
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('tenants.login');
}
public function destroyUser($id)
{
    $user = User::findOrFail($id);

  
   
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}
}
