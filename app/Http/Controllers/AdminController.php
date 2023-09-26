<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class AdminController extends Controller
{
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'User Logout Successfully', 
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }
    public function Profile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));

    }// End Methood
    public function EditProfile(){

        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.admin_profile_edit',compact('editData'));
    }// End Method 
    public function StoreProfile(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')) {
           $file = $request->file('profile_image');

           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/admin_images'),$filename);
           $data['profile_image'] = $filename;
        }
        $data->save();
$notification=array(
'message'=> "Admin Profile Updated Successfully",
'alert-type'=> "success"



);
        return redirect()->route('admin.profile')->with($notification);

    }// End Method
public function passwordchange(){
    
return view('admin.admin_password_change');


}
public function Updatepassword(Request $request){
    $validateData = $request->validate([
        'old_password' => 'required',
        'new_password' => 'required',
        'confirm_password' => 'required|same:new_password',

    ]);
$hashedPassword = Auth::user()->password;
if (Hash::check($request->old_password,$hashedPassword )) {
    $users = User::find(Auth::id());
    $users->password = bcrypt($request->new_password);
    $users->save();

    session()->flash('message','Password Updated Successfully');
    return redirect()->back();
} else{
    session()->flash('message','Old password is not match');
    return redirect()->back();
}
}

}
