@extends('layouts.app')
@section('content')
    <table class="table table-hover">
        <caption>Users table</caption>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Is admin</th>
            <th>Is active</th>
            <th>Is blocked</th>
            <th>Max disk space</th>
            <th>Disk space</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
    @foreach($users as $user)
            <tr>
                <td>
                  {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    {{ $user->is_admin }}
                </td>
                <td>
                    {{ $user->is_active }}
                </td>
                <td>
                    {{ $user->is_blocked }}
                </td>
                <td>
                    {{ $user->max_disk_space }}
                </td>
                <td>
                    {{ $user->disk_space }}
                </td>
                <td>
                    {{ $user->created_at }}
                </td>
                <td>
                    <a href="\users\{{$user->id}}\edit" class="btn btn-primary">Edit</a>
                </td>
            </tr>
        @endforeach
    </table>

@stop