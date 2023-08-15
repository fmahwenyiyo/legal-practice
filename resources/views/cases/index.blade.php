@extends('layouts.app')

@section('page-title', __('Case'))

@section('action-button')
    @can('create case')
        <div class="text-sm-end d-flex all-button-box justify-content-sm-end">
            <a href="{{ route('cases.create') }}" class="btn btn-sm btn-primary mx-1" data-toggle="tooltip"
                title="{{ __('Create Case') }}" data-bs-original-title="{{ __('Add Case') }}" data-bs-placement="top"
                data-bs-toggle="tooltip">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endcan

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">{{ __('Case') }}</li>
@endsection

@section('content')

    <div class="row p-0">
        <div class="col-xl-12">

            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('Court') }}</th>
                                <th>{{ __('Case') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Advocate') }}</th>
                                <th>{{ __('Hearing Date') }}</th>
                                <th>{{ __('Stage') }}</th>
                                <th width="100px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cases as $case)
                                <tr>
                                    <td>
                                        <a href="#" class="btn btn-sm"
                                            data-url="{{ route('cases.show', $case->id) }}" data-size="md"
                                            data-ajax-popup="true" data-title="{{ __('View Cause') }}">
                                            {{ App\Models\CauseList::getCourtById($case->court) }} -
                                            {{ App\Models\CauseList::getHighCourtById($case->highcourt) == '-'
                                                ? $case->casenumber
                                                : App\Models\CauseList::getHighCourtById($case->highcourt) }}
                                            - {{ App\Models\CauseList::getBenchById($case->bench) }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ !empty($case->casenumber) ? $case->casenumber : ' ' }} {{-- case type --}}
                                        {{ !empty($case->case_number) ? $case->case_number : $case->diarybumber }} /
                                        {{-- case number or diary number --}}
                                        {{ $case->year }}

                                    </td>

                                    <td>{{ $case->title }}</td>
                                    <td>{{ App\Models\Advocate::getAdvocates($case->your_advocates) }}</td>
                                    <td>{{ $case->hearing_date }}</td>
                                    <td>{{ $case->priority }}</td>
                                    <td>

                                        @can('view case')
                                            <div class="action-btn bg-light-secondary ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-url="{{ route('cases.show', $case->id) }}" data-size="md"
                                                    data-ajax-popup="true" data-title="{{ __('View Cause') }}"
                                                    title="{{ __('View') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"><i class="ti ti-eye "></i></a>
                                            </div>
                                        @endcan

                                        @can('edit case')
                                            <div class="action-btn bg-light-secondary ms-2">
                                                <a href="{{ route('cases.edit', $case->id) }}"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    title="{{ __('Edit') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ti ti-edit "></i>
                                                </a>
                                            </div>
                                        @endcan

                                        @can('delete case')
                                            <div class="action-btn bg-light-secondary ms-2">
                                                <a href="#"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para"
                                                    data-confirm="{{ __('Are You Sure?') }}"
                                                    data-confirm-yes="delete-form-{{ $case->id }}"
                                                    title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </div>
                                        @endcan
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['cases.destroy', $case->id],
                                            'id' => 'delete-form-' . $case->id,
                                        ]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

