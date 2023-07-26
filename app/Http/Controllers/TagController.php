<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use DragonCode\Contracts\Routing\Core\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create(Request $request){
        $data = $request->all();
        unset($data["_token"]);
        $tag = Tags::create($data);
        $randomColor = ["text-bg-primary", "text-bg-secondary","text-bg-success","text-bg-danger","text-bg-warning","text-bg-info","text-bg-dark"];
        $return = ["task_id"=>$data["task_id"], "name"=>$tag["name"], "randomColor"=>$randomColor, "id"=>$tag["id"]];

        return json_encode($return);
    }

    public function remove(Request $request){
        $tag_id = $request->get("id");
        $tag = Tags::find($tag_id);
        $tag->delete();
        return json_encode(["status"=>200, "tag_id"=>$tag_id]);
    }
}
