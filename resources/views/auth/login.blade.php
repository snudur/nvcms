@extends('frontend.layout')

@section('content')

    <div class="Page">

        <div class="uk-height-1-1" style="height: 500px;">
    
            <div class="uk-vertical-align uk-text-center uk-height-1-1">
                <div class="uk-vertical-align-middle" style="width: 250px;">

                    <form class="uk-panel uk-panel-box uk-form" method="POST" action="{{ url('/auth/login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="uk-form-row">
                            <input class="uk-width-1-1 uk-form-large" type="email" name="email" placeholder="Netfang">
                            @if($errors->first('email'))
                                <small class="error">Netfang vantar eða ekki rétt stimplað inn.</small>
                            @endif
                        </div>
                        <div class="uk-form-row">
                            <input class="uk-width-1-1 uk-form-large" type="password" name="password" placeholder="Lykilorð">
                            @if($errors->first('password'))
                                <small class="error">Lykilorð vantar eða ekki rétt.</small>
                            @endif
                        </div>
                        <div class="uk-form-row">
                            <button class="uk-width-1-1 takki" href="#">Innskrá</button>
                        </div>
                        <div class="uk-form-row uk-text-small">
                            <label class="uk-float-left"><input type="checkbox"> Muna eftir mér</label>
                            <!--// <a class="uk-float-right uk-link uk-link-muted" href="#">Forgot Password?</a> -->
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

@stop