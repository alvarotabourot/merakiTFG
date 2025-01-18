<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public static function getRoles(){
        $roles = Roles::all();

        return $roles;
    }
}
