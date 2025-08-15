<?php

namespace App\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller {

  public function index() {
    return Promocode::all();
  }

  // public function getDiscount(Request $request) {
  //   $promocode = $request->promocode;
  //   $promocode = Promocode::where('code', $promocode)->first();

  //   if ($promocode == null) {
  //     return response()->json(['message' => 'Promocode does not exist'], 409);
  //   }

  //   return response()->json(['message' => 'Promocode exists', 'promocode' => $promocode], 200);
  // }
  public function getDiscount(Request $request) {
    $promocode = $request->promocode;
    $promocode = Promocode::where('code', $promocode)->first();

    if ($promocode == null) {
      return response()->json(['message' => 'Promocode does not exist'], 409);
    }

    return response()->json(['message' => 'Promocode exists', 'promocode' => $promocode], 200);
  }
}
