<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\Tags;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public static function AjaxGetLink(){

        $data = request()->all();
        $user = User::find($data["user_id"]);
        $link = route("shareLink")."?_token={$data["_token"]}&user-owner-list={$user->name}&list_id={$data["list_id"]}";
        return json_encode($link);
    }
    public function index(Request $request){

        $list_id = $request->input("list_id");
        $user = $request->input("user-owner-list");
        $list = Lists::find($list_id);
        $tasks = Tasks::all();
        $tags = Tags::all();
        $randomColor = ["text-bg-primary", "text-bg-secondary","text-bg-success","text-bg-danger","text-bg-warning","text-bg-info","text-bg-dark"];

        if(isset(Auth::user()->id)){
            $lists = [$list];
            $from = "share";
            return view("lists.index", compact("lists","tasks", "tags", "randomColor", "from"));
        }else{
            return view("lists.share", compact("list","tasks", "tags", "randomColor", "user"));
        }

    }
}
