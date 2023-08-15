@extends('layouts.app')

@section('page-title', __('Add Case'))


@section('breadcrumb')
    <li class="breadcrumb-item">{{ __(' Add Case') }}</li>
@endsection

@php
    $setting = App\Models\Utility::settings();
@endphp

@section('content')

    {{ Form::open(['route' => 'cases.store', 'method' => 'post']) }}
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-lg-10">
            <div class="card shadow-none rounded-0 border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('court', __('Court'), ['class' => 'form-label']) !!}
                                {{ Form::select('court', $courts, '', ['class' => 'form-control  item', 'id' => 'court', 'required' => 'required']) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group d-none" id="casetype_div">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group d-none" id="casenumber_div">

                                {!! Form::label('casenumber', __('Case Type'), ['class' => 'form-label']) !!}

                                    <select id="casenumber" class="form-control  item" name="casenumber">
                                        <option value=""> {{ __('Please select') }} </option>
                                            @foreach (App\Models\Cases::caseType() as $typ)
                                                <option value="{{ $typ }}">{{ $typ }}</option>
                                            @endforeach
                                    </select>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group d-none" id="diarybumber_div">
                                {!! Form::label('diarybumber', __('Diary Number'), ['class' => 'form-label']) !!}
                                {{ Form::number('diarybumber', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group  d-none" id="highcourt_div">
                                {!! Form::label('highcourt', __('High Court'), ['class' => 'form-label']) !!}

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group  d-none" id="bench_div">
                                {!! Form::label('court', __('Bench'), ['class' => 'form-label']) !!}

                            </div>
                        </div>

                        <div class="col-md-6 " id="case_number_div">
                            <div class="form-group">
                                {{ Form::label('case_number', __('Case Number'), ['class' => 'col-form-label']) }}
                                {{ Form::number('case_number', null, ['class' => 'form-control']) }}
                                <small>{{ __('(Please enter the case number assigned by court)') }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('year', __('Year'), ['class' => 'col-form-label']) }}

                                <select class="form-control" name="year" id="year">
                                    <option value="">{{ __('Please Select') }}</option>
                                    @foreach (App\Models\Utility::getYears() as $year)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('filing_date', __('Date of filing'), ['class' => 'col-form-label']) }}
                                {{ Form::date('filing_date', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('court_hall', __('Court Hall'), ['class' => 'col-form-label']) }}
                                {{ Form::number('court_hall', null, ['class' => 'form-control']) }}
                            </div>
                        </div>



                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('floor', __('Floor'), ['class' => 'col-form-label']) }}
                                {{ Form::number('floor', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('title', __('Title'), ['class' => 'col-form-label']) }}
                                {{ Form::text('title', null, ['class' => 'form-control']) }}
                                <small> {{ __('(Please enter the title which you can remember easily)') }} </small>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
                                <small> {{ __('(Please enter primary details about the case, client, etc)') }} </small>
                                {{ Form::textarea('description', null, ['class' => 'form-control pc-tinymce-2', 'rows' => 2, 'placeholder' => __('Description'), 'id' => 'description']) }}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('before_judges', __('Before Hon\'ble Judge(s):'), ['class' => 'col-form-label']) }}
                                {{ Form::text('before_judges', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('referred_by', __('Referred By'), ['class' => 'col-form-label']) }}
                                {{ Form::text('referred_by', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('section', __('Section/Category'), ['class' => 'col-form-label']) }}
                                {{ Form::text('section', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('priority', __('Priority'), ['class' => 'col-form-label']) }}
                                <select name="priority" id="priority" class="form-control">
                                    <option value=""> {{ __('Please Select') }} </option>

                                    @foreach (App\Models\Cases::casePriority() as $priority)

                                        <option value="{{ $priority }}"> {{ $priority }} </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('under_acts', __('Under Act(s)'), ['class' => 'col-form-label']) }}
                                {{ Form::text('under_acts', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('under_sections', __('Under Section(s)'), ['class' => 'col-form-label']) }}
                                {{ Form::text('under_sections', null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('FIR_police_station', __('FIR Police Station'), ['class' => 'col-form-label']) }}
                                {{ Form::text('FIR_police_station', null, ['class' => 'form-control']) }}

                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('FIR_number', __('FIR Number'), ['class' => 'col-form-label']) }}
                                {{ Form::number('FIR_number', null, ['class' => 'form-control']) }}

                            </div>
                        </div>


                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('FIR_year', __('FIR Year'), ['class' => 'col-form-label']) }}
                                <select class="form-control" name="FIR_year" id="year">
                                    <option value="">{{ __('Please Select') }}</option>
                                    @foreach (App\Models\Utility::getYears() as $year)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('your_advocates', __('Your Advocates'), ['class' => 'col-form-label']) }}
                                {!! Form::select('your_advocates[]', $advocates, null, [
                                    'class' => 'form-control multi-select',
                                    'id' => 'choices-multiple',
                                    'multiple',
                                    'data-role' => 'tagsinput',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('your_team', __('Your Team'), ['class' => 'col-form-label']) }}
                                {!! Form::select('your_team[]', $team, null, [
                                    'class' => 'form-control multi-select',
                                    'id' => 'choices-multiple1',
                                    'multiple',
                                    'data-role' => 'tagsinput',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('hearing_date', __('Hearing Date'), ['class' => 'col-form-label']) }}

                                {{ Form::date('hearing_date', null, ['class' => 'form-control']) }}

                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('stage', __('Stage'), ['class' => 'col-form-label']) }}
                                {{ Form::text('stage', null, ['class' => 'form-control']) }}

                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('session', __('Session'), ['class' => 'col-form-label']) }}
                                <select name="session" id="session" class="form-control">
                                    <option value="Morning"> {{ __('Morning') }} </option>
                                    <option value="Evening"> {{ __('Evening') }} </option>

                                </select>

                            </div>
                        </div>



                        <div class="col-md-12 repeater">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card my-3 shadow-none rounded-0 border">
                                        <div class="card-header">
                                            <div class="row flex-grow-1">
                                                <div class="col-md d-flex align-items-center col-6">
                                                    <h5 class="card-header-title">{{ __('Opponents') }}</h5>
                                                </div>

                                                <div class="col-md-6 justify-content-between align-items-center col-6">
                                                    <div
                                                        class="col-md-12 d-flex align-items-center  justify-content-end">
                                                        <a data-repeater-create="" class="btn btn-primary btn-sm add-row text-white"
                                                            data-toggle="modal" >
                                                            <i class="fas fa-plus"></i> {{ __('Add Row') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table  mb-0 table-custom-style"
                                                    data-repeater-list="opponents" id="sortable-table">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Full Name') }}</th>
                                                            <th>{{ __('Email Address') }}</th>
                                                            <th>{{ __('Phone Number') }}</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" data-repeater-item>
                                                        <tr>
                                                            <td width="25%" class="form-group">
                                                                <input type="text" class="form-control opponents_name"
                                                                    name="opponents_name">
                                                            </td>
                                                            <td width="25%">
                                                                <input type="email" class="form-control opponents_email"
                                                                    name="opponents_email">
                                                            </td>
                                                            <td width="25%">
                                                                <input type="text" class="form-control opponents_phone"
                                                                    name="opponents_phone">
                                                            </td>
                                                            <td width="5%">
                                                                <a href="javascript:;"
                                                                    class="ti ti-trash text-white action-btn bg-danger p-3 desc_delete"
                                                                    data-repeater-delete></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 repeater">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-none rounded-0 border my-3">
                                        <div class="card-header">
                                            <div class="row flex-grow-1">
                                                <div class="col-md d-flex align-items-center col-6">
                                                    <h5 class="card-header-title">{{ __('Opponent Advocates') }}</h5>
                                                </div>

                                                <div class="col-md-6 justify-content-between align-items-center col-6">
                                                    <div
                                                        class="col-md-12 d-flex align-items-center  justify-content-end">
                                                        <a data-repeater-create="" class="btn btn-primary btn-sm add-row text-white"
                                                            data-toggle="modal" data-target="#add-bank">
                                                            <i class="fas fa-plus"></i> {{ __('Add Row') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive">
                                                <table class="table  mb-0 table-custom-style"
                                                    data-repeater-list="opponent_advocates" id="sortable-table">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Full Name') }}</th>
                                                            <th>{{ __('Email Address') }}</th>
                                                            <th>{{ __('Phone Number') }}</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="ui-sortable" data-repeater-item>
                                                        <tr>
                                                            <td width="25%" class="form-group">
                                                                <input type="text"
                                                                    class="form-control opp_advocates_name"
                                                                    name="opp_advocates_name">
                                                            </td>
                                                            <td width="25%">
                                                                <input type="email"
                                                                    class="form-control opp_advocates_email"
                                                                    name="opp_advocates_email">
                                                            </td>
                                                            <td width="25%">
                                                                <input type="number"
                                                                    class="form-control opp_advocates_phone"
                                                                    name="opp_advocates_phone">
                                                            </td>
                                                            <td width="5%">
                                                                <a href="javascript:;"
                                                                    class="ti ti-trash text-white action-btn bg-danger p-3 desc_delete"
                                                                    data-repeater-delete></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div><div class="col-md-1"></div>
        <div class="col-lg-10">
            <div class="card shadow-none rounded-0 border ">
                <div class="card-body p-2">
                    <div class="form-group col-12 d-flex justify-content-end col-form-label mb-0">

                        <a href="{{ route('cases.index') }}"
                            class="btn btn-secondary btn-light ms-3">{{ __('Cancel') }}</a>
                        <input type="submit" value="{{ __('Save') }}" class="btn btn-primary ms-2">
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{ Form::close() }}
    <!-- [ Main Content ] end -->
@endsection


@push('custom-script')
    <script>
        $(document).on('change', '#court', function() {
            var selected_opt = $(this).val();
            var seletor = $(this);

            $.ajax({
                url: "{{ route('get.highcourt') }}",
                datType: 'json',
                method: 'POST',
                data: {
                    selected_opt: selected_opt
                },
                success: function(data) {
                    if (data.status == 1) {
                        $('#highcourt_div').removeClass('d-none');
                        $('#highcourt_div').empty();
                        $('#casetype_div').addClass('d-none').empty();
                        $('#casenumber_div').addClass('d-none');
                        $('#diarybumber_div').addClass('d-none');

                        $('#highcourt_div').append(
                            '<label for="highcourt" class="form-label">High Court</label> <select class="form-control" name="highcourt" id="highcourt"> </select>'
                        );
                        $('#highcourt').append('<option value="">{{ __('Please Select') }}</option>');

                        $.each(data.dropdwn, function(key, value) {
                            $('#highcourt').append('<option value="' + key + '">' + value +
                                '</option>');
                        });

                    } else {
                        var text = $("#court option:selected").text();

                        $('#highcourt_div').addClass('d-none').empty();
                        $('#bench_div').addClass('d-none').empty();

                        $('#casetype_div').removeClass('d-none').append(
                            '<label for="casetype" class="form-label">' + text +
                            '</label><select class="form-control" name="casetype" id="casetype"> <option value="">{{ __('Please Select') }}</option><option value="Case Number">{{ __('Case Number') }}</option><option value="Diary Number">{{ __('Diary Number') }}</option></select>'
                        );



                        $(document).on('change', '#casetype', function() {
                            var type = $("#casetype option:selected").text();
                            $('#casenumber_div').addClass('d-none');
                            $('#diarybumber_div').addClass('d-none');
                            if (type == 'Case Number') {
                                $('#casenumber_div').removeClass('d-none');
                                $('#case_number_div').removeClass('d-none');

                            }
                            if (type == 'Diary Number') {
                                $('#case_number_div').addClass('d-none');
                                $('#diarybumber_div').removeClass('d-none');

                            }
                        });

                    }

                }
            })
        });

        $(document).on('change', '#highcourt', function() {
            var selected_opt = $(this).val();

            $.ajax({
                url: "{{ route('get.bench') }}",
                datType: 'json',
                method: 'POST',
                data: {
                    selected_opt: selected_opt
                },
                success: function(data) {
                    console.log(data.status);
                    if (data.status == 1) {
                        $('#bench_div').removeClass('d-none');
                        $('#bench_div').empty();
                        $('#bench_div').append(
                            '<label for="bench" class="form-label">Bench</label> <select class="form-control" name="bench" id="bench"> </select>'
                        );
                        $('#bench').append('<option value="">{{ __('Please Select') }}</option>');

                        $.each(data.dropdwn, function(key, value) {
                            $('#bench').append('<option value="' + key + '">' + value +
                                '</option>');
                        });

                        $('#danger-span').addClass('d-none').remove();
                    } else {
                        $('#bench_div').addClass('d-none').empty();
                        $('#danger-span').addClass('d-none').remove();
                        $('#highcourt_div').removeClass('d-none').append(
                            '<a href="#" data-url={{ route("bench.create") }} data-title="Add Bench" data-ajax-popup="true" data-size="md" title={{ __("Create New Bench") }}><span class="text-danger" id="danger-span">Please add bench to current high court</span></a>'
                            )
                    }

                }
            })

        });

        $(document).on('change', '#causelist_by', function() {
            $('#adv_label').html($(this).val())
        });

        $(document).on('change', '#bench', function() {

        });
    </script>

    <script src="{{ asset('public/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/assets/js/repeater.js') }}"></script>
    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                show: function() {
                    $(this).slideDown();
                    var file_uploads = $(this).find('input.multi');
                    if (file_uploads.length) {
                        $(this).find('input.multi').MultiFile({
                            max: 3,
                            accept: 'png|jpg|jpeg',
                            max_size: 2048
                        });
                    }
                    if ($('.select2').length) {
                        $('.select2').select2();
                    }

                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        if ($('.disc_qty').length < 6) {
                            $(".add-row").show();

                        }
                        $(this).slideUp(deleteElement);
                        $(this).remove();

                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }
                        $('.subTotal').html(subTotal.toFixed(2));
                        $('.totalAmount').html(subTotal.toFixed(2));
                    }
                },
                ready: function(setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }

        }

        $(".add-row").on('click',function(event) {
            var $length = $('.disc_qty').length;
            if ($length == 5) {
                $(this).hide();
            }
        });
        $(".desc_delete").on('click',function(event) {

            var $length = $('.disc_qty').length;
        });
    </script>

    <script src="{{ asset('assets/js/plugins/tinymce/tinymcenew.js') }}"></script>
    <script>
        if ($(".pc-tinymce-2").length) {
            tinymce.init({
                selector: '.pc-tinymce-2',
                height: "400",
                content_style: 'body { font-family: "Inter", sans-serif; }'
            });
        }
    </script>
@endpush
