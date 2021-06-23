<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\tree;

// Based om: https://www.itsolutionstuff.com/post/laravel-5-category-treeview-hierarchical-structure-example-with-demoexample.html

class treeController extends Controller
{
    function show(){
        if(session()->has('userID')){
            $tree = tree::whereNull('parentId') -> where('owner', session()->get('userID')) -> get();

            return view('tree', compact('tree'));
        }
        else{
            $info['title'] = 'Login requered!';
            $info['desc'] = 'You need to be loged in to see that page!';
            $info['type'] = 'danger';

            return view('login', compact('info'));
        }
    }

    function new($parentId, $name){
        $newElement = [
            'parentId' => $parentId,
            'owner'    => session()->get('userID'),
            'sort'     => 1,
            'title'    => $name
        ];

        tree::create($newElement);

    function edit($id, $newName){
        $e = tree::findOrFail($id);
        $e -> title = $newName;
        $e -> save();

        return redirect(url('tree'));
    }
        return redirect(url('tree'));
    }
}
