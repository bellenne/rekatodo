<?php

namespace App\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Models\Lists;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke()
    {
        $data = \request()->all();
        unset($data["_token"]);

        $newList = Lists::create($data);
        return json_encode($newList);
    }
}
