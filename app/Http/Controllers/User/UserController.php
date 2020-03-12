<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use http\Env\Response;
use Illuminate\Http\Request;

use App\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* REGLAS DE VALIDACION SI LOS DATOS SON CORRECTOS*/
            $reglas = [
                'name' => 'required',
                'email' => 'required | email | unique:users',
                'password' => 'required | min:6 | confirmed'
            ];

            $this->validate($request, $reglas);
        /*FIN */
        $campos = $request->all();

        $campos['password'] = bcrypt( $request->password );
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;
        $usuario = User::create($campos);
        return  $this->showOne($usuario, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $usuario = User::findOrFail($id); // retorna una execcion si no encuentra el usuario
        return  $this->showOne($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // selecionamos el usuario que vamos a actualizar

        $reglas = [

            'email' => 'email | unique:users,email'. $user->id,
            'password' => 'min:6 | confirmed',
            'admin' => 'in:'. User::USUARIO_ADMINISTRADOR . ','. User::USUARIO_REGULAR // VERIFICAR SI EL USUARIO SE VA A COMVERTIR EN ADMINISTRADO O VISEVERSA
                   ];
        $this->validate($request, $reglas); // validacion de las reglas
        if ($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email') && $user->email != $request->email ){
                $user->verified = User::USUARIO_NO_VERIFICADO;
                $user->verification_token = User::generarVerificationToken();
                $user->email = $request->email;
              }
        if ($request->has('password')){
            $user->password = bcrypt($request->password);

        }

        if ($request->has('admin')){
            if(!$user->esVerificado()){
                return $this->errorResponse(  'Unicamente los usuarios verificado pueden cambiar su valor como administrador', 409); // error 409 indica que enemos un conflicto con la peticion que realizo un usuario
            }
            $user->admin = $request->admin;
        }
        if (!$user->isDirty()){
            return $this->errorResponse( 'se debe especificar al menos un valor diferente para actualizar para actualizar', 422);

        }

        $user->save();
        return  $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return  $this->showOne($user);
    }
}
