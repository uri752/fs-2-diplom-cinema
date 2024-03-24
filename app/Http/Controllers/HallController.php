<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HallStoreRequest;
use App\Models\Hall;
use App\Models\Seat;
use App\Models\Session;

class HallController extends Controller
{
    public function create(HallStoreRequest $request)  
    {
        $validated = $request->validated();
        $hall = Hall::query()->create([
            'name' => $validated['name']
        ]);
        
        for ($i = 0; $i < 6; $i++) {
            Seat::query()->create([
                'hall_id' => $hall->id,
                'type_seat' => 'st',
            ]);
        }

        return redirect()->back();
    }

    public function delete(int $id) 
    {
        $sessions = Session::all();
        foreach ($sessions as $session) {
            if ($session->hall_id === $id) {
                Session::destroy($session->id);
            }
        }
        Seat::query()->where(['hall_id' => $id])->delete();
        Hall::destroy($id);

        return redirect('admin/index');
    }

    
    public function update(Request $request, int $id)
    {        
        $hall = Hall::find($id);        
        if ($hall) {
            $hall->fill($request->all());
            $hall->save();
        }
        return response()->json($hall);        
    }

    public function updateSeats(Request $request, int $id)
    {
        Seat::query()->where(['hall_id' => $id])->delete();
        $newSeats = $request->json();
        foreach ($newSeats as $newSeat) {
            Seat::query()->create($newSeat);
        }
        $seats = Seat::all();
        
        return response()->json($seats);
    }
}
