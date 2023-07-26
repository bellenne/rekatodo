<?php

namespace App\Http\Controllers;

use App\Http\Filters\TagFilter;
use App\Http\Requests\FilterRequest;
use App\Models\Lists;
use App\Models\Tags;
use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->title;
        $tasksGet = Tasks::where("tasks.title","LIKE","%$search%")->orderBy("title")->join("lists","tasks.list_id", "lists.id")->select("tasks.id","tasks.title","tasks.list_id","tasks.preview","tasks.isCompleted","lists.title AS list_title", "lists.id AS listId")->get();
        $lists = collect();
        $tasks = collect();
        foreach ($tasksGet as $task){
            $lists->push(["id"=>$task->listId,"title"=>$task->list_title]);
            $tasks->push(["id"=>$task->id, "title"=>$task->title, "preview"=>$task->preview, "isCompleted"=>$task->isCompleted, "list_id"=>$task->list_id]);
        }
        $tags = Tags::all();
        $randomColor = ["text-bg-primary", "text-bg-secondary","text-bg-success","text-bg-danger","text-bg-warning","text-bg-info","text-bg-dark"];
        $from = "search";
        $lists = $lists->unique();
        return view("lists.search", compact("lists","tasks", "tags", "randomColor", "from"));
    }

    public function filter(Request $request){
        $data = $request->all();
        $tagsFind = Tags::query();
        foreach ($data as $tag){
                $tagsFind->whereIn("id", $tag);
        }
        $tagsFind = $tagsFind->get();
        $tasks = Tasks::query();

        $task_ids = [];
        $list_ids = [];

        foreach ($tagsFind as $tag){
            array_push($task_ids, $tag->task_id);
        }
        $tasks = Tasks::whereIn("id",$task_ids)->get()->unique();

        foreach ($tasks as $task){
            array_push($list_ids, $task->list_id);
        }
        $list_ids = array_unique($list_ids);

        $lists = Lists::whereIn("id",$list_ids)->get();

        $tags = Tags::all();

        $randomColor = ["text-bg-primary", "text-bg-secondary","text-bg-success","text-bg-danger","text-bg-warning","text-bg-info","text-bg-dark"];
        $from = "search";

//        dd($tasks);

        return view("lists.index", compact("lists","tasks", "tags", "randomColor", "from", "tagsFind"));
    }
}
