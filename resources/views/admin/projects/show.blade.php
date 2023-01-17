
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-center mt-3">{{ $project->title }}</h1>
       
        <div class="d-flex justify-content-between mt-3">
            <h5>{{ $project->created_at }}</h5>
            <h5 class="text-primary">{{$project->type ? $project->type->name : "Nessun tipo"}}</h5>
            <p>{{ $project->slug }}</p>
        </div>
        <div class="technologies">
            @forelse ($technologies as $technology)
                <span>{{$technology->name}}</span>
            @empty
                <span>Nessuna Tecnologia</span>
            @endforelse
        </div>
        <div class="text-center">
            <img src="{{asset('storage/'.$project->cover_image)}}" alt="">
        </div>
        <p class="mt-3">{{ $project->content }}</p>
    </div>
@endsection