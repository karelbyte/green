<?php

namespace App\Http\Controllers;


use App\Models\Users\User;
use App\Models\Users\UserPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        return view('pages.users.list');
    }

    public function newview()
    {
        return view('pages.users.new');
    }

    public function getUserPositions()
    {
        return UserPosition::all();
    }

    public function getUsers()
    {
        return User::query()->select('id', 'name')->get();
    }

    public function getlanscapers()
    {
        return User::query()->where('position_id', UserPosition::LANDSCAPERS)->get();
    }

    // OBTIENE LA LISTA DE USUARIOS Y LOS ENVIA AL FRONT PAGINADO
    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->input('filters');

        $orders =$request->input('orders');

        $datos = User::with(['position', 'status', 'roles' => function ($q) {

            $q->select('id', 'name');

        }]);

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('users.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $roles = Role::select('id', 'name')->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'roles' => $roles,

            'positions' => UserPosition::all()
        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);
    }

    // CREA USUARIO CON SU ROL EN EL SISTEMA
    public function store(Request $request)
    {
        $data = $request->input('user');

        $user = User::where('email', $data['email'])->first();

        if (!empty($user)) return response()->json('Ya existe un usuario con ese email!', 500);

        $user = User::query()->create([

            'name' => $data['name'],

            'email' => $data['email'],

            'password' => Hash::make($data['password']),

            'active_id' => $data['active_id'],

            'position_id' => $data['position_id']
        ]);

        $user->assignRole($data['rol']['name']);


        return response()->json('Usuario añadido con exito!', 200);
    }

    // MODFICA USUARIO CON SU ROL EN EL SISTEMA
    public function update(Request $request, $id)
    {

        $data = $request->input('user');

        $user = User::query()->where('email', $data['email'])->where('uid', '<>', $id) ->first();

        if (!empty($user)) return response()->json('Ya existe un usuario con ese email!', 500);

        $user = User::findUid($id);

        $user->name = $data['name'];

        $user->email = $data['email'];

        $user->position_id = $data['position_id'];

        if (isset($data['password'])) { $user->password = Hash::make($data['password']); }

        $user->active_id = $data['active_id'];

        $user->save();

        // Rol
        $user->syncRoles([]);

        $user->assignRole($data['rol']);


        return response()->json('Datos actualizados con exito!', 200);
    }

    // ELIMINA USUARIO CON SU ROL EN EL SISTEMA
    public function destroy($id)
    {
        $user = User::findUid($id);

        $user->syncRoles([]);

        $user->delete();

        return response()->json('Datos eliminados con exito!', 200);

    }
}
