<?php

namespace App\Http\Controllers;

use App\Models\shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\items;

class ItemsController extends Controller
{
    public function update(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'shelf_id' => 'integer',
            'name' => 'string|max:50',
            'price' => 'numeric|min:0.01',
            'image_url' => 'url',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }
        $data = $validator->validated(); // get validated data

        // check if shelf exists
        if(isset($req['shelf_id'])){
            if(!shelf::find($req['shelf_id'])){
                return response()->json(['Error' => 'Not found', 'Message' => 'Specified shelf does not exist'], 404);
            }
        }


        $items = items::find($id); // find the specified record
        if(!$items){
            return response()->json(['Error' => 'Not found', 'Message' => 'Specified product does not exist'], 404);
        }

        if(!$items->update($data)){
            return response()->json(['Error' => 'Failed', 'Message' => 'Could not update specified product'], 500);
        }

        return response()->json(['Message' => 'Product was successfully updated!', 'Info' => $data]);
    }

    public function delete($id){
        $item = items::find($id);
        if(!$item){
            return response()->json(['Error' => 'Not found', 'Message' => 'Specified product does not exist'], 404);
        }

        if($item->delete()){
            return response()->json(['Message' => 'Product successfully removed']);
        }

        return response()->json(['Error' => 'Failed', 'Message' => 'Could not remove'], 500);
    }

    public function index(){
        return response()->json(items::all());
    }

    public function show($id){
        $item = items::find($id);
        if(!$item){
            return response()->json(['Error' => 'Not found', 'Message' => 'Specified product does not exist'], 404);
        }

        return response()->json(['product' => $item]);
    }

    public function create(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'shelf_id' => 'required|integer',
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0.01',
            'image_url' => 'required|url',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $data = $validator->validated();

        // check if shelf exists
        if(!shelf::find($data['shelf_id'])){
            return response()->json([
                'message' => 'Not found',
                'errors' => 'Specified shelf does not exist'
            ], 404);
        }
        

        $item = items::create($data);

        return response()->json(['message' => 'Product was created successfully', 'item' => $item], 201);
    }

}
