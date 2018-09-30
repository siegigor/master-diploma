@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header">Search Result</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p>Search image:</p>
                                <hr/>
                                <img src="{{ asset($result->image) }}" class="img">
                            </div>
                            <div class="col-md-9">
                                <p>
                                    <span>Result: </span>
                                    @if ($result->isFilm())
                                        <span class="badge badge-primary">Movie</span>
                                    @elseif ($result->isTv())
                                        <span class="badge badge-success">TV Show</span>
                                    @elseif ($result->isNotFound())
                                        <span class="badge badge-danger">Not found</span>
                                    @endif
                                </p>
                                <hr/>
                                <div class="row">
                                    @if (!$result->isNotFound())
                                    <div class="col-md-3">
                                        <img src="{{ asset($result->poster) }}" class="img">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="card-title">{{ $result->title }}</h5>
                                        <p class="card-text">{{ $result->description }}</p>
                                        <ul>
                                            <li><b>Rated: </b>{{ $result->rated }}</li>
                                            <li><b>Runtime: </b>{{ $result->runtime }}</li>
                                            <li><b>Genre: </b>{{ $result->genre }}</li>
                                            <li><b>Director: </b>{{ $result->director }}</li>
                                            <li><b>Writer: </b>{{ $result->writer }}</li>
                                            <li><b>Actors: </b>{{ $result->actors }}</li>
                                            <li><b>Language: </b>{{ $result->language }}</li>
                                            <li><b>Country: </b>{{ $result->country }}</li>
                                            <li><b>Rating: </b>{{ $result->vote_average }} / 10</li>
                                            <li><b>Release date: </b>{{ $result->release_date }}</li>
                                            <li><b>Awards: </b>{{ $result->awards }}</li>
                                        </ul>
                                    </div>
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            Sory, we can't identify this image. Maybe it's not a movie or TV show.
                                        </div>
                                    @endif
                                    <div class="col-md-12 text-right">
                                        <a class="btn btn-primary" href="{{ route('home') }}">Find another</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
