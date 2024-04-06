<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Seat;
use App\Models\Session;
use App\Models\User;
use App\Http\Requests\MovieStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
    public function index()
    {
        $halls = Hall::with('seat')->get();
        $seats = Seat::all();
        $movies = Movie::query()->paginate(10);
        $seances = Session::with('movie')->get();

        return view('admin.index', [
            'halls' => $halls,
            'movies' => $movies,
            'seances' => $seances,
            'seats' => $seats,
        ]);
    }
    
    public function createMovie(MovieStoreRequest $request)
    {                
        //$validated = $request->validated();                              
        Movie::query()->create([
            'title' => $request['name'],            
            'duration' => $request['duration'],
            'description' => $request['description'],
            'country' => $request['country']
        ]);
        
        return redirect()->back();
    }


    public function deleteMovie(int $id)
    {
        Movie::destroy($id);
        return redirect('admin/index');
    }  
}
