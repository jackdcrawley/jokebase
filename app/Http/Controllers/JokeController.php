<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\JokeResource;
use App\Models\Joke;

class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JokeResource::collection(Joke::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'          => 'required|string',
            'setup'         => 'required|string',
            'punchline'     => 'required|string'
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors()->all(), 400);
        }

        $joke = Joke::create([
            'type'          => $request->input('type'),
            'setup'         => $request->input('setup'),
            'punchline'     => $request->input('punchline')
        ]);

        return new JokeResource($joke);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new JokeResource(Joke::findOrFail($id));
    }
}
