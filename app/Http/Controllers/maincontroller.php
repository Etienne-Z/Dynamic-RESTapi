<?php

namespace App\Http\Controllers;

use App\Models\roles_permissions;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use function GuzzleHttp\Promise\exception_for;

class maincontroller extends Controller
{

  private $exception = null;
  private $success = true;
  private $data = null;
  private $message = null;
  private $global_token = null;
  private $user_role = null;

  #third run //  
  # - hash api_token
  # - give token back to created user
  # - add refresh token function 
  # - search package 

  # - update database for RBAC *DONE
  # - add RBAC (Role Base access system) * IN PROGRESS



  #EXTRA
  # - add comments to every function *DONE


  public function __construct(request $request){
          //check if request recieved the {api_token} variable and validates it
          // dd(request()->header("api_token"));

          if(!request()->hasHeader('api_token')){
              if(request()->has(['email', 'password'])){
                $credentials = $request->only('email', 'password');
              
                if(Auth::attempt($credentials)){
                      try {
                        $new_token = Hash::make(Str::random(60));   
                        user::find($credentials)->update([
                              'api_token' => $new_token
                        ]);
                        $this->global_token = $new_token;
                      }
                      catch(exception $exception){
                        $this->exception = $exception;
                        $this->success = false;
                        $this->message = "token generation failed";
                        return $this->response();
                      }

                    
                    }
                else{
                  $this->success = false;
                  $this->message = "No user found";

                  return $this->response(); 
                }
              }
              else {
                $this->success = false;
                $this->message = "No credentials where found";
                return $this->response(); 
              }
          }
          else {
            $this->global_token = request()->header('api_token');
          }

          try { 
          // dd($this->global_token);
          $this->user = User::all();
          // dd($user);
          // $roleperms =  roles_permissions::find($role_id);
           
           
          }
          catch(exception $exception){
            $this->exception = $exception;
            $this->success = false;
            $this->message = "no token found";
            return $this->response();
          }

          // check if request recieved the {id} variable and sets the id variable
          if(isset(request()->id)){
            $this->id = request()->id; }
          else {
            $this->id = null; }
          // check if request recieved the {model} variable and sets the id variable
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
              return $this->response(); } }
  
  public function getAll(){

    // model - permission
    try {
    // Gets all the records from the database and sets it into the $this->data variable.
      $this->data = $this->model::all();
      return $this->response();
    }
    catch(Exception $exception){
    // Set the exception into the $this->exception variable and sets $this->success to false for a failed API call.
      $this->exception = $exception;
      return $this->response();
    } }
  public function getOne(){
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
      } }
  public function save(request $request){
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
  public function delete(){
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
    } }
  public function update(request $request, $id){
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
    } }
      
  public function response(){
    // Creates the jSON response that is given back with every request.
    return response()->json([
      'success'  => $this->success,
      'data' => ($this->success ? $this->data : null),
      'message' => ($this->success ? "API call successful" : "API call failed, Something went wrong"),
      'exception' => $this->exception,
      'token' => $this->global_token,
      'error_message' => $this->message,
      'user' => $this->user
    ]); }
  } 
