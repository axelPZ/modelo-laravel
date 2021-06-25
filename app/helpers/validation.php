<?php

namespace App\helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Role;

class validation
{
    public function inputs( $data ){





    }

    // validar si el rol existe en la DB
    public function validateRole( $role='' ){

        $roles = new Role;
        $result = $roles->where('rol_name', $role)->first();
        if( isset( $result ) ){

            return true;

        }else{

            return false;
        }
    }
}

