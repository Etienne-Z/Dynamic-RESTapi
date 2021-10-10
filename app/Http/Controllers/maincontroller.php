<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class maincontroller extends Controller
{

  private $exception = null;
  private $success = true;
  private $data = null;

  #first run  // 11/06/2021
  # - add dynamic CRUD  *DONE
  # - add dynamic validation *DONE
  # - add dynamic API routes *DONE

  #second run // 
  # - add token validation
  # - update database for token validation
  # - route validation with token
  # - add private variables for respond function *DONE
  # - add fail responses 

  #third run //  
  # - update database for RBAC
  # - add RBAC (Role Base access system) 


  #EXTRA
  # - add comments to every function *DONE

  public function __construct(){
          // check if request recieved the {id} variable
          if(isset(request()->id)){
            $this->id = request()->id; }
          else {
            $this->id = null; }
          // check if request recieved the {model} variable
          if(isset(request()->model)){
            $this->name = request()->model; }
          else {
            $this->success = false;
            $this->exception = "No name found";
            return $this->response(); }
        $var = '\\App\\Models\\' . ucfirst($this->name);
          // check if model exists.
          if(class_exists($var)){
            $this->model = new $var(); }
          else {
              $this->success = false;
              $this->exception = "model does not exist";
              return $this->response(); } }
  
  public function getAll(){
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
            $this->exception = "Validation failed";
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
        $this->exception = "Validation failed";
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
      
  public function apiTokenUpdate(){

    $token = Str::random(60);

      $this->model->forceFill([
        'api_token' => hash('sha256', $token),
    ])->save();

    return ['token' => $token];

  }
  
  
  
  public function response(){
      // Creates the jSON response that is given back with every request.
    return response()->json([
      'success'  => $this->success,
      'data' => $this->data,
      'message' => ($this->success ? "API call successful" : "API call failed, Something went wrong"),
      'exception' => $this->exception,
    ]);}
  }
