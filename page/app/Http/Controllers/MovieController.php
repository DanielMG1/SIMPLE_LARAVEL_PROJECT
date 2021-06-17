<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Mail\NotificationMailable;
use Illuminate\Support\Facades\Mail;

/**
 * Class MovieController
 * @package App\Http\Controllers
 */
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::paginate();

        return view('movie.index', compact('movies'))
            ->with('i', (request()->input('page', 1) - 1) * $movies->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $movie = new Movie();
        return view('movie.create', compact('movie'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Movie::$rules);

        $movie = Movie::create($request->all());

        $mail = new NotificationMailable;
        Mail::to('danielmelangiraldo@gmail.com')->send($mail);

        return redirect()->route('movies.index')
            ->with('success', 'Movie created successfully.', 'Message was sent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);

        return view('movie.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movie = Movie::find($id);

        return view('movie.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        request()->validate(Movie::$rules);

        $movie->update($request->all());
        $mail = new NotificationMailable;
        Mail::to('danielmelangiraldo@gmail.com')->send($mail);

        return redirect()->route('movies.index')
            ->with('success', 'Movie updated successfully','Message was sent');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $movie = Movie::find($id)->delete();
        $mail = new NotificationMailable;
        Mail::to('danielmelangiraldo@gmail.com')->send($mail);

        return redirect()->route('movies.index')
            ->with('success', 'Movie deleted successfully', 'Message was sent');
    }
}
