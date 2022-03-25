@component('mail::message')
# Introduction

The body of your message.


<a href="{{route('authen_order', $token)}}">{{route('authen_order', $token)}}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent