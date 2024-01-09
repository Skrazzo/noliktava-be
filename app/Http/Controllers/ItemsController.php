<?php

namespace App\Http\Controllers;

use App\Models\shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\items;

class ItemsController extends Controller
{
    

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
