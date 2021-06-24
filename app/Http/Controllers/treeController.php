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

    function sortUp($id){
        return self::sort($id,'<', 'desc');
    }
    
    function sortDown($id){
        return self::sort($id,'>', 'asc');
    }

    //oa - operator aritmetic ('>'/'<'); st - sort type (asc/desc)
    function sort($id, $oa, $st){
        $about = tree::findOrFail($id);

        $temp = $about -> sort;
        $otherID = tree::where('parentId', $about->parentId) -> where('sort', $oa, $temp) -> orderBy('sort', $st) -> first() -> id;
        $otherObject = tree::findOrFail($otherID);
        $about -> sort = $otherObject -> sort;
        $otherObject -> sort = $temp;

        $about -> save();
        $otherObject -> save();

        return redirect(url('tree'));
    }

    function _move($o){
        if($o -> parentId == null)
            return $o->title;
        else
            return self::_move(tree::findOrFail($o->parentId)) . '/' . $o->title;
    }

    function move($id){
        $e = tree::findOrFail($id);

        $allElements = tree::where('owner', $e->owner) -> get();
        foreach($allElements as $E)
            $E -> title = self::_move($E);

        return view('move', compact('e', 'allElements'));
    }

    function processMove(request $r){
        $temp = tree::findOrFail($r->id);
        $temp -> parentId = $r -> newParent;
        $temp -> save();
        
        return redirect(url('tree'));
    }
}