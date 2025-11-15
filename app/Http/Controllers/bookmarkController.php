<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bookmarkController extends Controller
{
    public function bookmark(){
        $bookmarks =[
            ['nama' => 'Raditya Dika', 'waktu' => '4', 'isi' => 'jangan sombong, ntar ada balesannya loh','like' => '5k', 'komentar' => '11k'],
            ['nama' => 'Fahrezi Rasyid', 'waktu' => '1', 'isi' => 'hahaha lucu','like' => '100k', 'komentar' => '50k']
        ];
        return view('users.bookmark',compact('bookmarks'));
}
}