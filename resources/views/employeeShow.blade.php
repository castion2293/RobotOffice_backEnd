@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span><strong>員工資料: {{ $name }}</strong></span>
                    </div>

                    <user-info
                        :presents="{{ $presents }}"
                        :holidays="{{ $holidays }}"
                        :trips="{{ $trips }}"
                        :rests="{{ $rests }}"
                    >
                    </user-info>
                </div>
            </div>
        </div>
    </div>
@endsection
