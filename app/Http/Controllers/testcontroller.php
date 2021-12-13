<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class testcontroller extends Controller
{
    public function testUser(){
    
        return user::all();
    }
}
