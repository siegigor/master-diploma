@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Find movies and tv shows by image</div>

                <div class="card-body">
                    <upload-form
                        action="{{ route('upload') }}"
                    ></upload-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
