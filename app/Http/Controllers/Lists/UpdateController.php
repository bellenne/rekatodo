<?php

namespace App\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Models\Lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    public function update()
    {
        $data = \request()->all();
        $list = Lists::find($data["id"]);
        $list->update([
            "title"=>$data["title"]
        ]);

        $list = Lists::find($data["id"]);
        return json_encode($list);
    }
}
