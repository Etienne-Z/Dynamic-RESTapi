<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;

class maincontroller extends Controller
{
  public function __construct()
  {
        $this->name = request()->model;
        $var = '\\App\\Models\\' . ucfirst($this->name);
          // check if model exists.
        if(class_exists($var)){
        $this->model = new $var();
        }
        else {
    }
  }
  
  public function getAll(){
        try {

          $data = $this->model::all();
          $exception = null;
          return $this->response(false,$data,$exception);
        }
        catch(Exception $exception){
          $data = null;
          return $this->response(true,$data,$exception);
        }

  }
  public function getOne($id){
    try {
      dd($id);
        $data = $this->model::find($id);
        $exception = null;
        return $this->response(false,$data,$exception);
      }
      catch(Exception $exception){

        $data = null;
        return $this->response(true,$data,$exception);
      }
  }
  public function save(request $request){
      try {              

            $vm = '\App\Http\Requests\\' . ucfirst($this->name) . 'Request'; 
            $validator =  (new $vm())->rules();
            $validate = Validator::make($request->all(), $validator);
            if($validate->fails()){
              report($validate);
            }
            else{
              $this->model->fill($request->all())->save();
            }
        
        $data = null;
        $exception = null;
        return $this->response(false,$data,$exception);
      }
      catch(Exception $exception){

        $data = null;
        return $this->response(true,$data,$exception);
      }
    }
  public function delete($id)
  {
      try {
        dd($id);
        $data = $this->model::find($id)->delete();
        $exception = null;
        return $this->response(false,$data,$exception);
          }
      catch(Exception $exception){

        $data = null;
        return $this->response(true,$data,$exception);
      }
  }
  public function update(request $request, $id)
  {
    try {

      $vm = '\App\Http\Requests\\' . ucfirst($this->name) . 'Request'; 
      $validator =  (new $vm())->rules();
      // dd($validator);

      $validate = Validator::make($request->all(), $validator);
      if($validate->fails()){
        report($validate);
      }
      else{
        // dd($request->all());
        $this->model::find($id)->fill($request->all())->save();
      }
        $data = null;
        $exception = null;
        return $this->response(false,$data,$exception);
        }
      catch(Exception $exception){

        return $this->response(true,$data,$exception);
    }
  }
      public function response(bool $error  , $data , $exception){

          if($error == true){
            
              return response()->json([
                
                'error' => $error,
                'data' => null,
                'message' => "something went wrong",
                'exception' => $exception,
                      
              ],500);
              
            }
            else if($error == false) {
              
              return response()->json([
                
                'error' => $error,
                'data' => $data,
                'message' => "API call successful ",
                'exception' => 'none',
                
              ],200);
            }
      }
  }
