<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function manuals()
    {
        $files=[];
        $file_list = Storage::disk('public')->allFiles('manuals');
        foreach ($file_list as $key=>$file) {
            $pieces = explode("/", $file);
            $files[ucfirst($pieces[1])][$key]['name'] = $pieces[2];
            $files[ucfirst($pieces[1])][$key]['url'] = url($file);
        }

        return view('manuals')->with(
            [
                'files' => $files,
            ]
        );
    }
}
