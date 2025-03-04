@php($title = __('servers.title_servers_list') )

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('servers.game_servers') }}</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success' href="{{ route('admin.servers.create') }}"><span class="fa fa-plus-square"></span>&nbsp;{{ __('servers.create') }}</a>
    <hr>

    @include('components.grid', [
        'modelsList' => $servers,
        'labels' => [__('servers.name'), __('servers.game'), __('servers.ip_port')],
        'attributes' => ['name', 'game.name', ['twoSeparatedValues', ['server_ip', ':', 'server_port']]],
        // 'viewRoute' => 'admin.servers.show',
        'editRoute' => 'admin.servers.edit',
        'destroyRoute' => 'admin.servers.destroy',
    ])

    {!! $servers->links() !!}
@endsection