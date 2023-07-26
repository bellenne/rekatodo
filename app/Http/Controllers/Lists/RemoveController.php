<?php

namespace App\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Models\Lists;
use App\Models\Tasks;
use Illuminate\Http\Request;

class RemoveController extends Controller
{
    public function __invoke()
    {
        $data = \request()->all();
        $list = Lists::find($data["id"]);
        $tasks = Tasks::where("list_id",$data["id"])->delete();
        $list->delete();
        return json_encode(["status"=> 200, 'id'=>"collapse".$data["id"]]);
    }
}
