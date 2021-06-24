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
        if(tree::where('parentId', $parentId) -> orderBy('sort', 'desc') -> count())
            $temp = tree::where('parentId', $parentId) -> orderBy('sort', 'desc') -> first() -> sort +1;
        else
            $temp = 1;

        $newElement = [
            'parentId' => $parentId,
            'owner'    => session()->get('userID'),
            'sort'     => $temp,
            'title'    => $name
        ];

        tree::create($newElement);

        return redirect(url('tree'));
    }

    function edit($id, $newName){
        $e = tree::findOrFail($id);
        $e -> title = $newName;
        $e -> save();

        return redirect(url('tree'));
    }

    function delete($id){
        $e = tree::findOrFail($id);

        if(tree::where('parentId', $id) -> get() -> count() > 0){
            $temp = tree::where('parentId', $id) -> get();

            foreach($temp as $t)
                self::delete($t->id);
        }
        $e -> delete();

        return redirect(url('tree'));
    }
}
