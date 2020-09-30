@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card-body" id="app">
                <chat-app :user="{{ auth()->user() }}" />
            </div>
        </div>
    </div>
</div>
@endsection
