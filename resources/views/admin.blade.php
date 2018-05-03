@extends('layouts.app')

@section('content')

@inject('CalendarPresenter', 'App\Presenters\CalendarPresenter')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span><strong>行事曆</strong></span>
                </div>

                <calendar-view inline-template :year="{{ $year }}" :month="{{ $month }}" v-cloak>
                    <v-app>
                        <v-card-title primary-title class="hidden-xs-only">
                            <div class="headline"><strong>{{ $year }}年 {{ $month }}月</strong></div>
                            <v-spacer></v-spacer>
                            <a href="{{ url('admin?year=' . $CalendarPresenter->year($year, $month, 'subMonth') .
                                '&month=' . $CalendarPresenter->month($year, $month, 'subMonth') . '&method=AdminCalendar') }}">
                                <v-btn><v-icon>keyboard_arrow_left</v-icon></v-btn>
                            </a>
                            <a href="{{ url('admin?year=' . $CalendarPresenter->year($year, $month, 'addMonth') .
                                '&month=' . $CalendarPresenter->month($year, $month, 'addMonth') . '&method=AdminCalendar') }}">
                                <v-btn><v-icon>keyboard_arrow_right</v-icon></v-btn>
                            </a>
                        </v-card-title>

                        <v-container fluid>
                            <calendar schedules="{{ $data }}"></calendar>
                        </v-container>
                    </v-app>
                </calendar-view>
            </div>
        </div>
    </div>
</div>
@endsection
