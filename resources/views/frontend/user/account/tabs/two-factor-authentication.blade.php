@if ($logged_in_user->hasTwoFactorEnabled())
    <h4>@lang('Two Factor Authentication is Enabled')</h4>

    <a href="{{ route('frontend.user.account.2fa.delete') }}" class="btn btn-danger btn-sm btn-block">@lang('Remove Two Factor Authentication')</a>
    <a href="{{ route('frontend.user.account.2fa.show') }}" class="btn btn-primary btn-sm btn-block">@lang('View/Regenerate Recovery Codes')</a>
@else
    <h4>@lang('Two Factor Authentication is Disabled')</h4>

    <a href="{{ route('frontend.user.account.2fa.create') }}" class="btn btn-success btn-sm btn-block">@lang('Enable Two Factor Authentication')</a>
@endif
