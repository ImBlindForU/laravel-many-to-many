@extends('layouts.admin')


@section('content')
    <div class="container">
        <h2 class="text-center mt-3">crea un nuovo post</h2>
        <div class="row justify-content-center">
            <div class="col-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    
                    </div>
                @endif
                <form action="{{ route('admin.project.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    

                    <div class="form-group mb-3">
                        <label for="title">Titolo</label>
                        <input  type="text" name="title" id="title" class="form-control @error('title')
                            is-invalid
                        @enderror " value="{{ old('title')  }}">
                        @error('title')
                            <div class="invalid-feedback">Error</div>
                            
                        @enderror
                    </div>


                    <div class="form-group mb-3">
                        <label for="type">Tipo</label>
                        <select name="type_id" id="type" class="form-select">
                            <option value="">Nessuno tipo</option>
                                @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                                
                            @endforeach
                        </select>
                       
                    </div>


                    <div class="form-group mb-3">
                        <h4>Technologies</h4>

                        @foreach ($technologies as $technology)
                        <div class="form-check">
                            <input type="checkbox" name="technologies[]" value="{{$technology->id}}"  id="technology-{{$technology->id}}" class="form-check-input">
                            <label for="technology-{{$technology->id}}" class="form-check-label">{{$technology->name}}</label>
                        </div>
                        @endforeach
                        
                    </div>



                    {{-- img --}}
                    <div class="form-group mb-3">
                        <label for="cover_image">Immagine</label>
                        <input type="file" id="cover_image" name="cover_image" class="form-control" @error('cover_image')
                            is-invalid
                        @enderror>
                        @error('cover_image')
                            {{$message}}
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="content">Contenuto</label>
                        <textarea  value="{{ old('content')  }}" type="text" name="content" id="content" class="form-control" ></textarea>
                    </div>

                    <button class="btn btn-success" type="submit">Salva</button>
                </form>
            </div>
        </div>
    </div>
@endsection