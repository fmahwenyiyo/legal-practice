@extends('layouts.app')


@section('page-title', __('Dashboard'))

@section('content')
<div class="col-sm-12">

    <div class="row g-0">
        <!-- [ sample-page ] start -->
        <div class="col-12">
            <div class="row overflow-hidden g-0 pt-0 g-0 pt-0 row-cols-1  row-cols-md-2 row-cols-xxl-5 row-cols-lg-4 row-cols-sm-2">
                <div class="col border-end border-bottom">
                    <div class="p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-home"></i>
                            </div>
                            <div>
                                <p class="text-muted text-sm mb-0">{{__('Total')}}</p>
                                <h6 class="mb-0">{{__('Cases')}}</h6>
                            </div>
                        </div>
                        <h3 class="mb-0">{{ count($cases) }} </h3>
                    </div>
                </div>

                <div class="col border-end border-bottom">
                    <div class="p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-click"></i>
                            </div>
                            <div>
                                <p class="text-muted text-sm mb-0">
                                    {{__('Total')}}
                                </p>
                                <h6 class="mb-0">{{__('Advocates')}}</h6>
                            </div>
                        </div>
                        <h3 class="mb-0"> {{ count($advocate) }} </h3>
                    </div>
                </div>

                <div class="col border-end border-bottom">
                    <div class="p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-report-money"></i>
                            </div>
                            <div>
                                <p class="text-muted text-sm mb-0">{{__('Total')}}</p>
                                <h6 class="mb-0">{{__('Documents')}}</h6>
                            </div>
                        </div>
                        <h3 class="mb-0"> {{ count($docs) }} </h3>
                    </div>
                </div>
                
                <div class="col border-end border-bottom">
                    <div class="p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="theme-avtar bg-secondary">
                                <i class="ti ti-users"></i>
                            </div>
                            <div>
                                <p class="text-muted text-sm mb-0">{{__('Total')}}</p>
                                <h6 class="mb-0">{{__('Team Members')}}</h6>
                            </div>
                        </div>
                        <h3 class="mb-0">{{ count($members) }}</h3>
                    </div>
                </div>
                <div class="col border-end border-bottom">
                    <div class="p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="theme-avtar bg-danger">
                                <i class="ti ti-thumb-up"></i>
                            </div>
                            <div>
                                <p class="text-muted text-sm mb-0">{{__('Total')}}</p>
                                <h6 class="mb-0">{{__('To-Dos')}}</h6>
                            </div>
                        </div>
                        <h3 class="mb-0">{{ count($todos) }} </h3>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12">
                <div class="row g-0">
                    <!-- [ sample-page ] start -->
                    <div class="col-md-6 col-lg-3 border-end border-bottom scrollbar">
                        <div class="card shadow-none bg-transparent force-overflow">
                            <div class="card-header card-header border-bottom-0">
                                <h5>{{ __('Today Hearing Dates') }}</h5>

                            </div>
                            <div class="card-body p-0">
                                <div class="scroll-add">
                                    <ul class="list-group list-group-flush" id="todayhear">

                                        @if (count($todatCases) > 0)
                                            @foreach ($todatCases as $upcoming )
                                            <li class="list-group-item">
                                                <div class="row align-items-center justify-content-between">
                                                    <div class="col-sm-auto mb-3 mb-sm-0">


                                                        {{$upcoming['title']}}
                                                    </div>
                                                    <div class="col-sm-auto text-sm-end d-flex align-items-center">


                                                        {{$upcoming['hearing_date']}}
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">
                                                {{__('No record found')}}
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 border-end border-bottom scrollbar">
                        <div class="card shadow-none bg-transparent force-overflow">
                            <div class="card-header card-header border-bottom-0">
                                <h5>{{ __('Today To-Dos') }}</h5>

                            </div>
                            <div class="card-body p-0">
                                <div class="scroll-add" >
                                    <ul class="list-group list-group-flush" id="todaytodo">

                                        @if (!empty($todayTodos))
                                            @foreach ($todayTodos as $upcoming )
                                            <li class="list-group-item">
                                                <div class="row align-items-center justify-content-between">
                                                    <div class="col-sm-auto mb-3 mb-sm-0">

                                                        {{$upcoming['description']}}
                                                    </div>
                                                    <div class="col-sm-auto text-sm-end d-flex align-items-center">

                                                        {{$upcoming['start_date']}}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        @else
                                        <li class="list-group-item">
                                            {{__('No record found')}}
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 border-end border-bottom scrollbar">
                        <div class="card shadow-none bg-transparent force-overflow">
                            <div class="card-header card-header border-bottom-0">
                                <h5>{{ __('Upcoming Hearing Dates') }}</h5>

                            </div>
                            <div class="card-body p-0">
                                <div class="scroll-add" >
                                    <ul class="list-group list-group-flush" id="cominghere">
                                        @if (!empty($upcoming_case))
                                        @foreach ($upcoming_case as $upcoming )
                                        <li class="list-group-item">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-sm-auto mb-3 mb-sm-0">


                                                    {{$upcoming['title']}}
                                                </div>
                                                <div class="col-sm-auto text-sm-end d-flex align-items-center">


                                                    {{$upcoming['hearing_date']}}
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                        @else
                                        <li class="list-group-item">
                                            {{__('No record found')}}
                                        </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 border-end border-bottom scrollbar">
                        <div class="card shadow-none bg-transparent force-overflow">
                            <div class="card-header card-header border-bottom-0">
                                <h5>{{ __('Upcoming To-Dos') }}</h5>

                            </div>
                            <div class="card-body p-0">
                                <div class="scroll-add" >
                                    <ul class="list-group list-group-flush "id="comingtodo">
                                        @if (!empty($upcoming_todo))
                                            @foreach ($upcoming_todo as $upcoming )
                                            <li class="list-group-item">
                                                <div class="row align-items-center justify-content-between">
                                                    <div class="col-sm-auto mb-3 mb-sm-0">

                                                        {{$upcoming['description']}}
                                                    </div>
                                                    <div class="col-sm-auto text-sm-end d-flex align-items-center">

                                                        {{$upcoming['start_date']}}
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">
                                                {{__('No record found')}}
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ sample-page ] end -->
                </div>
            </div>

        </div>
        <!-- [ sample-page ] end  -->
    </div>
</div>
@endsection

@push('custom-script')
    <script>
        var px = new SimpleBar(document.querySelector("#todaytodo"), {
            autoHide: true
        });
        var px = new SimpleBar(document.querySelector("#cominghere"), {
            autoHide: true
        });
        var px = new SimpleBar(document.querySelector("#comingtodo"), {
            autoHide: true
        });
        var px = new SimpleBar(document.querySelector("#todayhear"), {
            autoHide: true
        });
    </script>
@endpush
