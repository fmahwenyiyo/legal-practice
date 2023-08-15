<div class="modal-body">
<div class="row">
    <div class="col-lg-12">

        <div class="">
            <dl class="row">
                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Court:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ App\Models\CauseList::getCourtById($case->court) }}</span>
                </dd>

                @if (!empty($case->casetype) && (!empty($case->casenumber) || !empty($case->diarybumber)))
                    <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Casetype:') }}</span></dt>
                    <dd class="col-md-8"><span class="text-md">{{ $case->casetype }}</span></dd>

                    <dt class="col-md-4"><span class="h6 text-md mb-0">{{ $case->casetype }}</span></dt>
                    <dd class="col-md-8"><span
                            class="text-md">{{ !empty($case->casenumber) ? $case->casenumber : $case->diarybumber }}</span>
                    </dd>
                @endif

                @if (!empty($case->highcourt))
                    <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('High Court:') }}</span></dt>
                    <dd class="col-md-8"><span
                            class="text-md">{{ App\Models\CauseList::getHighCourtById($case->highcourt) }}</span></dd>
                @endif

                @if (!empty($case->bench))
                    <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Bench:') }}</span></dt>
                    <dd class="col-md-8"><span
                            class="text-md">{{ App\Models\CauseList::getBenchById($case->bench) }}</span></dd>
                @endif

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Date of filing:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->filing_date }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Court Hall:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->court_hall }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Floor:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->floor }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Title:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->title }}</span></dd>

        

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Before Hon\'ble Judge(s):') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->before_judges }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Referred By:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->referred_by }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Section/Category:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->section }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Priority:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->priority }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Under Act(s):') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->under_acts }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Under Section(s):') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->under_sections }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('FIR Police Station:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->FIR_police_station }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('FIR Year:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ $case->FIR_year }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Your Advocates:') }}</span></dt>
                <dd class="col-md-8"><span
                        class="text-md">{{ App\Models\Advocate::getAdvocates($case->your_advocates) }}</span></dd>

                <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Your Team:') }}</span></dt>
                <dd class="col-md-8"><span class="text-md">{{ App\Models\User::getTeams($case->your_team) }}</span>
                </dd>


                @if (!empty($case->opponents))

                    <div class="col-12">
                        <hr class="mt-2 mb-2">
                        <h5>{{ __('Opponents') }}</h5>
                    </div>

                    @foreach (json_decode($case->opponents, true) as $key => $opp)
                        <dt class="col-md-12"><span class="h6 text-md mb-0">{{ __('Opponents ' . $key + 1) }}</span> </dt>

                        <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Name:') }}</span></dt>
                        <dd class="col-md-8"><span class="text-md">{{ $opp['opponents_name'] }}</span></dd>

                        <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Email:') }}</span></dt>
                        <dd class="col-md-8"><span class="text-md">{{ $opp['opponents_email'] }}</span></dd>

                        <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Phone:') }}</span></dt>
                        <dd class="col-md-8"><span class="text-md">{{ $opp['opponents_phone'] }}</span></dd>
                    @endforeach
                @endif

                @if (!empty($case->opponent_advocates))

                    <div class="col-12">
                        <hr class="mt-2 mb-2">
                        <h5>{{ __('Opponent Advocates') }}</h5>
                    </div>

                    @foreach (json_decode($case->opponent_advocates, true) as $key => $opp)
                        <dt class="col-md-12"><span class="h6 text-md mb-0">{{ __('Opponents Advocates ' . $key + 1) }}</span></dt>

                        <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Name:') }}</span></dt>
                        <dd class="col-md-8"><span class="text-md">{{ $opp['opp_advocates_name'] }}</span></dd>

                        <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Email:') }}</span></dt>
                        <dd class="col-md-8"><span class="text-md">{{ $opp['opp_advocates_email'] }}</span></dd>

                        <dt class="col-md-4"><span class="h6 text-md mb-0">{{ __('Phone:') }}</span></dt>
                        <dd class="col-md-8"><span class="text-md">{{ $opp['opp_advocates_phone'] }}</span></dd>
                    @endforeach
                @endif


                <div class="col-12">
                    <hr class="mt-2 mb-2">
                    <h5>{{ __('Description') }}</h5>
                </div>

                <dd class="col-md-8"><span class="text-md">{!! $case->description !!}</span></dd>


            </dl>
        </div>

    </div>

</div>
</div>
