<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $users = User::all();
    return view('user.index', ['users' => $users]);
  }

  public function create(Request $request)
  {
    return view('user.create');
  }

  public function edit($id)
  {
    // return $id;
    $user = User::find($id);
    return view('user.edit', ['user' => $user]);
  }

  public function store(Request $request)
  {
    $user = new User;
    $user->email = $request->email;
    $user->password = Hash::make( $request->password );
    $user->save();

    return redirect('officiumtutus/updateuser?result=success');
  }

  public function update(Request $request, $id) {
    $user = User::find($id);

    if(Hash::check($request->old_password, $user->password)) {
      $user->email = $request->email;
      $user->password = Hash::make( $request->password );
      $user->save();

      return redirect('officiumtutus/updateuser?result=success');

    }else 
      return redirect('officiumtutus/updateuser?result=fail');
    
  }

  public function destroy($id)
  {
      //
      $ids = explode(',', $id);

      $affectedRows = false;

      foreach ($ids as $key => $each_id) {
        $user = User::find($each_id);
        $user->delete();   
        $affectedRows = true;       
      }

      if($affectedRows) {
          return response()->json(['message' => 'Successfully deleted'], 200);    
      }else {
          return response()->json(['message' => 'Request failed', 'error' => $error], 412);    
      }
  }
}