@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-frontend.card>
                <x-slot name="header">
                    {{ __('Verify Your Email Address') }}
                </x-slot>

                <x-slot name="body">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},

                    <x-forms.post :action="route('frontend.auth.verification.resend')" class="d-inline">
                        <x-forms.submit class="btn btn-link p-0 m-0 align-baseline" :text="__('click here to request another')" />
                    </x-forms.post>
                </x-slot>
            </x-frontend.card>
        </div><!--col-md-8-->
    </div><!--row-->
@endsection
