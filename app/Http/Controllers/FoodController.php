<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    // set index page view
	public function index() {
		$foods = Food::with('FoodOrigins');
		return view('food.index', compact('foods'));
	}

	public function visitorFood() {
		$foods = Food::all();
		return view('welcome', compact('foods'));
	}

    // handle fetch all eamployees ajax request
	public function fetchAll() {
		$foods = Food::all();
		// $foods = Food::with('FoodOrigins')->where('id',$id);
		$output = '';
		if ($foods->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Rate</th>
                <th>Discount</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($foods as $food) {
				$output .= '<tr>
                <td>' . $food->id . '</td>
                <td>' . $food->name . '</td>
                <td><img src="storage/foods/' . $food->image . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $food->price . '</td>
                <td>' . $food->rate . '</td>
                <td>' . $food->discount . '</td>
                <td>' . $food->description . '</td>
                <td>
                  <a href="#" id="' . $food->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editFoodModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $food->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

    // handle insert a new food ajax request
	public function store(Request $request) {
		$file = $request->file('image');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/foods', $fileName);

		$foodsData = ['name' => $request->name,'image' => $fileName, 'price' => $request->price, 'rate' => $request->rate, 'discount' => $request->discount, 'description' => $request->description ];
		Food::create($foodsData);
		return response()->json([
			'status' => 200,
		]);
	}

    
	// handle edit an food ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$food = Food::find($id);
		return response()->json($food);
	}


	// handle update an food ajax request
	public function update(Request $request) {
		$fileName = '';
		$food = Food::find($request->food_id);
		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/foods', $fileName);
			if ($food->image) {
				Storage::delete('public/foods/' . $foods->image);
			}
		} else {
			$fileName = $request->food_image;
		}

		$foodData = ['name' => $request->name, 'image' => $fileName, 'price' => $request->price, 'rate' => $request->rate, 'discount' => $request->discount, 'description' => $request->description];

		$food->update($foodData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete an Food ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$food = Food::find($id);
		if (Storage::delete('public/foods/' . $food->image)) {
			Food::destroy($id);
		}
	}

}
