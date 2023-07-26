<?php

namespace App\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Models\Lists;
use App\Models\Tags;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function __invoke()
    {
        $lists = Lists::all()->where("user_id","=",Auth::user()->id);
        $tasks = Tasks::all();
        $tags = Tags::all();
        $randomColor = ["text-bg-primary", "text-bg-secondary","text-bg-success","text-bg-danger","text-bg-warning","text-bg-info","text-bg-dark"];
        $from = "index";
        return view("lists.index", compact("lists","tasks", "tags", "randomColor", "from"));
    }
}
