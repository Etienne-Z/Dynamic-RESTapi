<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class maincontroller extends baseController
{




  public function __construct(request $request){

          //check if request recieved the {api_token} variable and validates it
          if(!request()->hasHeader('api_token')){
            if($request->has('email') && $request->has('password')){
                  try {
                    $credentials = $request->only('email', 'password');
                      $u = User::find($credentials);
                      // dd($u);
                      if(isset($u)){
                        $newtoken = Hash::make(Str::random(60));
                        $u->update(['api_token' => $newtoken])->save();
                        $this->gtoken = $newtoken;
                      }
                      else {
                        $this->success = false;
                        $this->message = "No user found";
                        return $this->response();  
                      }
                  }
                  catch(Exception $exception){
                    $this->success = false;
                    $this->exception = $exception;
                    return $this->response();  
                  }
            }
          }
          else {
            $this->success = false;
            $this->message = "No credentials where found";
            return $this->response(); 
          }          

          // ----------------------------------------------------------- \\

          // check if request recieved the {id} variable and sets the id variable
          if(isset(request()->id)){
            $this->id = request()->id; }
          else {
            $this->id = null; }
          // check if request recieved the {model} variable and creates the model object
          if(isset(request()->model)){
            $this->name = request()->model; }
          else {
            $this->success = false;
            $this->message = "No name found";
            return $this->response(); }
        $var = '\\App\\Models\\' . ucfirst($this->name);
          // check if model exists.
          if(class_exists($var)){
            $this->model = new $var(); }
          else {
              $this->success = false;
              $this->message = "model does not exist";
              return $this->response(); 
          }       
  }

        // Gets user -> gets role_id -> gets list of permissions -> sets list into the $this-user-permissions field

  public function getAll(){
    //makes permission:
    $perm = ucfirst(request()->model) . '_getall';
    // $check = this.checkperm($perm); 
    if($this->checkperm($perm)) {
      try {
        // Gets all the records from the database and sets it into the $this->data variable.
          $this->data = $this->model::all();
          return $this->response();
        }
        catch(Exception $exception){
        // Set the exception into the $this->exception variable and sets $this->success to false for a failed API call.
          $this->success = false;
          $this->exception = $exception;
          return $this->response();
        } 
    }
    else{
      $this->success = false;
      $this->message = "unauthorized for this action";
      return $this->response();
    }
  }
    
  public function getOne(){ 
    //makes permission:
    $perm = ucfirst(request()->model) . '_getone';
    // If the check function returns TRUE then it can run the action.
    if($this->checkperm($perm)){
      try {
        // Finds the correct Record and Set it into the $this->data variable. 
          $this->data = $this->model::find($this->id);
          return $this->response();
        }
        catch(Exception $exception){
        // Set the exception into the $this->exception variable and sets $this->success to false for a failed API call.
          $this->exception = $exception;
          $this->success = false;
          return $this->response();
        } 
    }
    else{
      $this->success = false;
      $this->message = "unauthorized for this action";
      return $this->response();
    }
  }
  public function save(request $request){
    //makes permission:
    $perm = ucfirst(request()->model) . '_save';
    // If the check function returns TRUE then it can run the action.
    if($this->checkperm($perm)){
      try {              
        // Finds the right Validator for the request and validates the request. 
        $vm = '\App\Http\Requests\\' . ucfirst($this->name) . 'Request'; 
        $validator =  (new $vm())->rules();
        $validate = Validator::make($request->all(), $validator);
        if($validate->fails()){
        // Gives back the right response if the validate fails. 
          $this->message = "Validation failed";
          return $this->response();
        }
        else{
        // Creates the record in the database.
          $this->model->fill($request->all())->save();
        }

        return $this->response();
      }
      catch(Exception $exception){
        // Set the exception into the $this->exception variable and sets $this->success to false for a failed API call.
        $this->exception = $exception;
        $this->success = false;
        return $this->response();
      }
    }
    else{
      $this->success = false;
      $this->message = "unauthorized for this action";
      return $this->response();
    }  
  }

  public function delete(){
    //makes permission:
    $perm = ucfirst(request()->model) . '_delete';    
    // If the check function returns TRUE then it can run the action.
    if($this->checkperm($perm)){
      try {
        // Deletes record from database.
        $this->model::find($this->id)->delete();
        return $this->response();
          }
      catch(Exception $exception){
        // Set the exception into the $this->exception variable and sets $this->success to false for a failed API call.
        $this->exception = $exception;
        $this->success = false;
        return $this->response(); 
      }
    }
    else{
      $this->success = false;
      $this->message = "unauthorized for this action";
      return $this->response();
    }
  }

  public function update(request $request, $id){
    //makes permission:
    $perm = ucfirst(request()->model) . '_getone';
    // If the check function returns TRUE then it can run the action.
    if($this->checkperm($perm)){
      try {
        // Finds the right Validator for the request and validates the request. 
        $vm = '\App\Http\Requests\\' . ucfirst($this->name) . 'Request'; 
        $validator =  (new $vm())->rules();
        $validate = Validator::make($request->all(), $validator);
        if($validate->fails()){
        // Gives back the right response if the validate fails. 
          $this->message = "Validation failed";
          return $this->response();
        }
        else{
        // Updates the data in the database.
          $this->model::find($this->id)->fill($request->all())->save();
        }
          return $this->response();
        }
        catch(Exception $exception){
        // Set the exception into the $this->exception variable and sets $this->success to false for a failed API call.
          $this->exception = $exception;
          $this->success = false;
          return $this->response();
      } 
    }
    else{
      $this->success = false;
      $this->message = "unauthorized for this action";
      return $this->response();
    }
  }
}