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
        if(tree::where('parentId', $parentId) -> where('title', $name) -> get() -> count()){
            $tree = tree::whereNull('parentId') -> where('owner', session()->get('userID')) -> get();

            $info['type'] = 'warning';
            $info['title'] = 'This name is alredy used!';
            $info['desc'] = 'You can use same name only once in the same parent!';

            return view('tree', compact('tree', 'info'));
        }

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

        $o = tree::where('parentId', $e->parentId) -> where('title', $newName) -> first();
        if($o && $o->id != $id){
            $tree = tree::whereNull('parentId') -> where('owner', session()->get('userID')) -> get();

            $info['type'] = 'warning';
            $info['title'] = 'This name is alredy used!';
            $info['desc'] = 'You can use same name only once in the same parent!';

            return view('tree', compact('tree', 'info'));
        }

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

        if(tree::where('parentId', $about->parentId) -> orderBy('sort', $st == 'desc' ? 'asc' : 'desc') -> first() -> id == $id){
            $tree = tree::whereNull('parentId') -> where('owner', session()->get('userID')) -> get();
            
            $info['type'] = 'danger';
            $info['title'] = 'Requered forbidden!';
            $info['desc'] = 'You cannot move ' . ($oa == '>' ? 'last' : 'first') . ' element ' . ($oa == '>' ? ' below!' : 'over!');
        
            return view('tree', compact('tree', 'info'));
        }

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
    
    function checkMove($o, $id){
        if($o->parentId == null)
            return true;
        else if($o -> parentId == $id || $o -> id == $id)
            return false;
        else
            return self::checkMove(tree::findOrFail($o->parentId), $id);
    }

    function move($id){
        $e = tree::findOrFail($id);

        $allElements = tree::where('owner', $e->owner) -> get();
        foreach($allElements as $key => $value)
            if(self::checkMove($value, $id))
                $value -> title = self::_move($value);
            else
                unset($allElements[$key]);
                
        return view('move', compact('e', 'allElements'));
    }

    function processMove(request $r){
        if(self::checkMove(tree::findOrFail($r->newParent), $r->id)){
            $temp = tree::findOrFail($r->id);

            if(tree::where('parentId', $r -> newParent) -> orderBy('sort', 'desc') -> count())
                $t = tree::where('parentId', $r -> newParent) -> orderBy('sort', 'desc') -> first() -> sort +1;
            else
                $t = 1;

            $temp -> sort = $t;
            $temp -> parentId = $r -> newParent;
            $temp -> save();

            return redirect(url('tree'));
        }
        else{
            $tree = tree::whereNull('parentId') -> where('owner', session()->get('userID')) -> get();

            $info['type'] = 'danger';
            $info['title'] = 'Invalid parent!';
            $info['desc'] = 'You cannot move ' . tree::findOrFail($r->id)->title . ' there!';

            return view('tree', compact('tree', 'info'));
        }
    }
}