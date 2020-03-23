@component('mail::message')
# {{ __('trainer invitation') }}

{{ __('you got an invitation on ausbilder.org from :company.', ['company' => $company->name]) }}

@component('mail::button', ['url' => env('APP_URL') . '/company/' . $company->hashid() . '/invite/' . $code])
{{ __('view invitation') }}
@endcomponent

{{ __("if you haven't an ausbilder.org account yet, register on for free.") }}

@component('mail::button', ['url' => env('APP_URL') . '/register'])
    {{ __('register a free account') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
