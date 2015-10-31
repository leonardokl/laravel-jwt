<?php

namespace App;

use Illuminate\Http\Response;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    // Tabela do banco
    protected $table = 'users';

    // Atributos que podem ser utilizados nos inputs
    protected $fillable = ['name', 'email', 'password'];

     // Atributos excluidos das views
    protected $hidden = ['password', 'remember_token'];

    public function allUsers()
    {
       return self::all(); 
    }

    public function saveUser($input)
    {               
        $input['password'] = Hash::make($input['password']);
        $user = new User(); 
        $user = $input;      
        User::create($user);
        return $user;
    }

    public function getUser($id)
    {
        $user = self::find($id);

        if(is_null($user)) {
            return false;
        }
        return $user;
    }

    public function updateUser($input, $id)
    {   
        $user = Self::find($id);
        
        //validações
        if(is_null($user)) {
            return $user = null;
        }

        if(isset($input['name'])) {
            $user->name = $input['name'];             
        }

        if(isset($input['email'])) {
            $user->email = $input['email'];             
        }

        if(isset($input['password'])) {
            $user->password = Hash::make($input['password']);             
        }

        $user->save();
        return $user;
    }

    public function deleteUser($id)
    {
        $user = self::find($id);

        if(!$user) {
            return $user = null;
        }       

        $user->delete(); 
        return $user;    
    }
}
