<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Role;
use App\User;
use App\Category ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request){
       //check if logged in and  admin user...........
       if(!Auth::check() && $request->path() != 'login'){
           return redirect('/login');
                 }
          if(!Auth::check() && $request->path() == 'login'){
           return view('welcome');
                 }       
                 //you are already logged in  so check if ur admin user
           $user = Auth::user();
           if($user->userType =='User'){
            return redirect('/login');
            }
           if($request->path() == 'login'){
             return redirect('/'); 
         }  
       return $this->checkForPermission($user, $request);
    }
    public function checkForPermission($user, $request){

         $permission = json_decode($user->role->permission);
        $hasPermission = false;
        if(!$permission) return view('welcome');
        foreach($permission as $p){
            if($p->name==$request->path()){
                if($p->read){
                    $hasPermission = true;
                }
            }
        }
        if($hasPermission) return view('welcome');
        return view('welcome');
        return view('notfound');
    }
     public function logout(){
       Auth::logout();
       return redirect('/login');
     }
    public function addTag(Request $request )
    {
        //validate rquest
      $this->validate($request,[
         'tagName' => 'required'
      ]); 
      return Tag::create([
          'tagName' => $request->tagName 
      ]);
    }
     public function editTag(Request $request )
    {
        //validate rquest
      $this->validate($request,[
         'tagName' => 'required',
          'id' => 'required'
      ]);

      return Tag:: where('id', $request->id)->update([
             'tagName' => $request->tagName
      ]);
    }
     public function deleteTag(Request $request )
    {
        //validate rquest
      $this->validate($request,[

          'id' => 'required'
      ]);

      return Tag:: where('id', $request->id)->delete();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTag()
    {
       return Tag::orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->validate($request,[
           'file' => 'required|mimes:jpeg,jpg,png'
        ]);
      $picName = time().'.'.$request->file->extension();
      $request->file->move(public_path('uploads'), $picName );
      return  $picName ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFilefromServer($fileName, $hasFullPath = false)
    {
      if(!$hasFullPath){
        $filePath = public_path().'/uploads/'.$fileName; 
      }
       
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_image(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFilefromServer($fileName, false);
        return  'done';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request)
    {
       //validate rquest
      $this->validate($request,[
         'categoryName' => 'required',
          'iconImage' => 'required'
      ]); 
      return Category::create([
          'categoryName' => $request->categoryName,
           'iconImage' => $request->iconImage
      ]);
    }

  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCategory()
    {
         return Category::orderBy('id', 'desc')->get();
    }

     public function editCategory(Request $request)
    {
      //validate rquest
      $this->validate($request,[
         'categoryName' => 'required',
          'iconImage' => 'required'
      ]);

      return Category:: where('id', $request->id)->update([
                'categoryName' => $request->categoryName,
                'iconImage' => $request->iconImage
      ]);
    }
    public function deletecategory(Request $request){
      //delete orginal file from server
      $this->deleteFilefromServer($request->iconImage);
      //validate request
      $this->validate($request,[
         'id' => 'required',
      ]);
      return Category::where('id', $request->id)->delete();
    }
    
    public function adduser(Request $request){
       //validate rquest
      $this->validate($request,[
         'FullName' => 'required',
          'password' => 'bail|required|min:6',
           'email' => 'bail|required|email|unique:users',
          'role_id' => 'required'
      ]); 
      $password = bcrypt($request->password);
      $user = User::create([
          'FullName' => $request->FullName,
           'email' => $request->email,
            'password' => $password,
           'role_id' => $request->role_id
      ]);
      return $user;
    }
   public function getusers()
    {
      // where('userType', '!=', 'User')->
       return User::get();
    }
     public function edituser(Request $request )
    {
        //validate rquest
      $this->validate($request,[
         'FullName' => 'required',
          'password' => 'min:6',
          'email' => "bail|required|email|unique:users,email,$request->id",
          'role_id' => 'required'
           ]); 
      $data = [
            'FullName' => $request->FullName,
            'email' => $request->email,
            'role_id' => $request->role_id, 
      ];
      if($request->password){
          $password = bcrypt($request->password);
          $data['password'] =   $password;
      }
      $users = User::where('id', $request->id)->update($data);
      return $users;

    }
      public function addRole(Request $request){
    //validate request
    $this->validate($request, [
         'rolename' => 'required',
      ]);
     return Role::create([
        'rolename' => $request->rolename
      ]);
    }
       public function getroles(){
        return Role::all();
    }
    public function editrole(Request $request){
         $this->validate($request, [
         'rolename' => 'required',
      ]);
        return Role:: where('id', $request->id)->update([
             'rolename' => $request->rolename]);

    }
    public function deleterole(Request $request){
       $this->validate($request,[

          'id' => 'required'
      ]);

      return Role:: where('id', $request->id)->delete();

    }
      public function deleteuser(Request $request )
    {
       $this->validate($request,[
          'id' => 'required'
      ]); 

      return User:: where('id', $request->id)->delete();
    }
    public function  adminlogin(Request $request){
            //validate rquest
       $this->validate($request,[
          'password' => 'bail|required|min:6',
          'email' => 'bail|required|email',
           ]); 
           if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             $user = Auth::user();
              if($user->role->isAdmin == 0){
            
               Auth::logout();
               return response()->json([
                 'msg'=>'Incorect login details',
               ], 401);
             }
               return response()->json([
                 'msg' => 'You are logged in',
                 'user' =>   $user
               ]);
           }else{
                 return response()->json([
                 'msg' => 'incorrect loggin details'
                 ],401);
           }
    }
     public function assignrole(Request $request){
        $this->validate($request,[

          'permission' => 'required',
          'id' => 'required'
      ]);
      return Role::where('id', $request->id)->update([
        'permission' => $request->permission
      ]);
      
    }
   
    

}
