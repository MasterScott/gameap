@extends('layouts.main')

@section('content')

    <div class="card mb-2">
        <div class="card-header">
            {{ __('home.main') }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-nowrap">
                    <div class="p-2 mb-3 text-center menu-item">
                        <a class="btn btn-block btn-lg btn-outline-dark rounded" href="/servers">
                            <i class="fas fa-server fa-5x m-1"></i>
                            <h5>{{ __('home.servers_list') }}</h5>
                        </a>
                    </div>
                </div>

                @foreach ($modules as $module)
                    @if (!empty($module["main-route"]))
                        <div class="d-flex flex-nowrap">
                            <div class="p-2 mb-3 text-center menu-item">
                                <a class="btn btn-block btn-lg btn-outline-dark rounded" href="{{ $module["main-route"] }}">

                                    @if (!empty($module["icon"]))
                                        {!! $module["icon"] !!}
                                    @else
                                        <i class="fas fa-server fa-5x m-1"></i>
                                    @endif

                                    <h5>{{ $module["name"] }}</h5>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-header">
            {{ __('home.information') }}
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-2"><i class="fas fa-info-circle"></i> {{ __('home.your_version') }}: {{ Config::get('constants.AP_VERSION') }}</div>
                    <div class="col-2">{{ __('home.latest_stable') }}: {{ $latestVersion }}</div>
                    <div class="col-2">{{ __('home.latest_beta') }}: 3.0.0-beta</div>
                    <div class="col-2">{{ __('home.latest_unstable') }}: 3.0.0-dev</div>
                </div>
            </div>

            <div class="col-12">
                <i class="fab fa-github"></i> GitHub:
                <a href="https://github.com/et-nik/gameap">https://github.com/et-nik/gameap</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <a href="{{ route('help') }}" class="btn btn-block btn-lg btn-warning rounded">
                <i class="fas fa-hands-helping"></i> {{ __('home.get_help') }}
            </a>
        </div>

        <div class="col-4">
            <a href="https://docs.gameap.ru" class="btn btn-block btn-lg btn-info rounded">
                <i class="fas fa-book"></i> {{ __('home.documentation') }}
            </a>
        </div>

        <div class="col-4">
            <a href="{{ route('report_bug') }}" class="btn btn-block btn-lg btn-danger rounded">
                <i class="fas fa-bug"></i> {{ __('home.report_bug') }}
            </a>
        </div>
    </div>

@endsection
