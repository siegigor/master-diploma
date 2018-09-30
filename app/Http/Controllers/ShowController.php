<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\View\View;

/**
 * Class ShowController
 * @package App\Http\Controllers
 */
class ShowController extends Controller
{
    /**
     * @param Result $result
     * @return View
     */
    public function show(Result $result): View
    {
        return view('show.show', compact('result'));
    }
}
