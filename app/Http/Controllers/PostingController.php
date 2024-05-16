<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posting;

class PostingController extends Controller
{
    public function index()
    {
        $postings = Posting::all();
        return view('posting.index', compact('postings'));
    }
}
