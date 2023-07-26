<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function update(){
        $data = \request()->all();
        $task = Tasks::find($data["id"]);
        if($data["action"] == "completed"){
            $update = [
                "isCompleted"=>$data["isCompleted"]
            ];
        }elseif ($data["action"] == "imgDelete"){
            $update =[
                "preview" => null
            ];
        }
        $task->update($update);
        return $data;
    }

    public function create(Request $request){
        $hasFile = $request->hasFile("preview");
        $data = $request->all();
        if($hasFile == 1){
            $path = "uploads/users/".$data["user"];
            $path = $request->file("preview")->store($path, "public");
            $path = "storage/".$path;
        }else{
            $path = null;
        }

        $newTask = Tasks::create([
            "list_id"=>$data["list_id"],
            "preview"=>$path,
            "title"=>$data["title"]
        ]);
        return json_encode($newTask);
//        Tasks::create();
    }

    public function remove(Request $request){
        $data = $request->all();
        $task = Tasks::find($data["id"]);
        $task->tags()->delete();
        $task->delete();
        return json_encode(["status"=>200, "task_id"=>$data["id"]]);
    }
    public function updateAll(Request $request){
        $hasFile = $request->hasFile("preview");
        $data = $request->all();
        $update = [];
        if($hasFile == 1){
            $path = "uploads/users/".$data["user"];
            $path = $request->file("preview")->store($path, "public");
            $path = "storage/".$path;
            $update = ["title"=>$data["title"], "preview"=>$path];
            $previewExist = true;
        }else{
            $update = ["title"=>$data["title"]];
            $previewExist = false;
        }
        $task = Tasks::find($data["task_id"]);

        $task->update($update);
        return json_encode(["id"=>$data["task_id"], "data"=>$update,"previewExist"=> $previewExist]);
    }
}
