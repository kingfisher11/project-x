@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Index') }}</div>

                <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Date Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                
                    <tr>
                    <td>{{ $user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at ? $user->created_at->diffForHumans() : 'Tidak Pasti'}}</td>
                    
                    </tr>
                @endforeach


                </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
