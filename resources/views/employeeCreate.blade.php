@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span><strong>新增員工資料</strong></span>
                    </div>


                    <form method="POST" action="{{ url('admin/employee') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-2 mt-3 col-form-label text-md-right">
                                <strong>姓名</strong>
                            </label>

                            <div class="col-md-10 mt-3 pr-md-5">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 mt-3 col-form-label text-md-right">
                                <strong>郵件信箱</strong>
                            </label>

                            <div class="col-md-10 mt-3 pr-md-5">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start" class="col-md-2 mt-3 col-form-label text-md-right">
                                <strong>到職日期(ex:2018-04-30)</strong>
                            </label>

                            <div class="col-md-10 mt-3 pr-md-5">
                                <input id="start" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="start" value="{{ old('start') }}" required autofocus>

                                @if ($errors->has('start'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('start') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hours" class="col-md-2 mt-3 col-form-label text-md-right">
                                <strong>特休時數(ex:56.0)</strong>
                            </label>

                            <div class="col-md-10 mt-3 pr-md-5">
                                <input id="hours" type="text" class="form-control{{ $errors->has('hours') ? ' is-invalid' : '' }}" name="hours" value="{{ old('hours') }}" required autofocus>

                                @if ($errors->has('hours'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('hours') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-9">
                                <button type="submit" class="btn btn-primary">
                                    <strong>新增</strong>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
@endsection

