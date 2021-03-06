@extends('layouts.app')
@section('content')
    <a href="\users\create" class="btn btn-primary" ><i class="fa fa-plus" aria-hidden="true"></i>  @lang('users.create') </a>
    <br />
    <br />
    <table class="table table-hover">
        <tr>
            <th>@lang('users.name')</th>
            <th>@lang('users.email')</th>
            <th>@lang('users.is_admin')</th>
            <th>@lang('users.is_active')</th>
            <th>@lang('users.is_blocked')</th>
            <th>@lang('users.max_space')</th>
            <th>@lang('users.current_space')</th>
            <th>@lang('users.created')</th>
            <th>@lang('users.action')</th>
        </tr>
    @foreach($users as $user)
            <tr id="{{$user->id}}">
                <td>
                  {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    @if($user->is_admin)
                        <i class="fa fa-check icon-green-center" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-times icon-red-center" aria-hidden="true"></i>
                    @endif
                </td>
                <td>
                    @if($user->is_active)
                        <i class="fa fa-check icon-green-center" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-times icon-red-center" aria-hidden="true"></i>
                    @endif
                </td>
                <td>
                    @if($user->is_blocked)
                        <i class="fa fa-check icon-green-center" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-times icon-red-center" aria-hidden="true"></i>
                    @endif
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
                    <a href="\users\{{$user->id}}\edit" class="btn btn-primary" data-toggle="tooltip" title="@lang('users.edit')"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                    <a href="#" class="btn btn-danger delete-user"  data-user-id="{{$user->id}}" data-toggle="tooltip" title="@lang('users.delete')" ><i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                </td>
            </tr>

        @endforeach
    </table>

@stop

