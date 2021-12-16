<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\True_;

class baseController extends Controller
{

    private $exception = null;
    private $success = true;
    private $data = null;
    private $message = null;
    private $gtoken = null;
    private $user = null;


    
    public function checkperm($perm){
        $count = 0;
        foreach($this->user->permissions as $i){
            if($i == $perm){
                return true;
            }
            if($count > count($this->user->permissions)){
                return false;
            }
            $count++;
        }
    }

    public function response(){
        // Creates the jSON response that is given back with every request.
        return response()->json([
          'success'  => $this->success,
          'data' => ($this->success ? $this->data : null),
          'message' => ($this->success ? "API call successful" : "API call failed, Something went wrong"),
          'exception' => $this->exception,
          'token' => $this->gtoken,
          'error_message' => $this->message,
          'user' => $this->user,
        ]); }
}
