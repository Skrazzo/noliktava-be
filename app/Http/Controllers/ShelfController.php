<?php

namespace App\Http\Controllers;

use App\Models\items;
use App\Models\shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ShelfController extends Controller
{
    public function create(Request $req){
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:50',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $data = $validator->validated();

        $new = shelf::create($data);
        if($new){
            return response()->json([
                'shelf' => $new
            ], 201);
        }

        return response()->json([
            'Error' => 'Failed',
            'Message' => 'Failed to create new shelf'
        ], 500);
    }

    public function index(){
        return response()->json(shelf::withCount('items')->get());
    }

    public function list_shelf($id){
        if(!shelf::find($id)){
            return response()->json(['Error' => 'Not found', 'Message' => 'Specified shelf could not be found!'], 404);
        }

        return response()->json(['items' => items::where('shelf_id', $id)->get()]);
    }   

    public function update(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:50',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $data = $validator->validated();

        $shelf = shelf::find($id);
        if(!$shelf){
            return response()->json([
                'Error' => 'Not found',
                'Message' => 'Couldn\'t find the specified shelf'
            ], 404);
        }

        if($shelf->update($data)){
            return response()->json(['Message' => 'Shelf ' . $shelf['name'] . ' updated successfully!']);
        }

        return response()->json([
            'Error' => 'Failed',
            'Message' => 'Shelf "' . $shelf['name'] . '" could not be updated successfully!'
        ]);
    }

    public function delete($id){
       
        $shelf = shelf::find($id);
        if(!$shelf){
            return response()->json([
                'Error' => 'Not found',
                'Message' => 'Couldn\'t find the specified shelf'
            ], 404);
        }

        if($shelf->delete()){
            return response()->json(['Message' => 'Shelf ' . $shelf['name'] . ' deleted successfully!']);
        }
        
        return response()->json([
            'Error' => 'Failed',
            'Message' => 'Shelf "' . $shelf['name'] . '" could not be deleted successfully!'
        ]);

    }
}
