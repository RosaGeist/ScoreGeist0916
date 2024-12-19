@component('vendor.mail.html.message')
<div style="background-color: #B2D9C4; padding: 20px; text-align: center;">
    <img src="{{ $logo }}" alt="{{ config('app.name') }}" style="width: 150px; margin-bottom: 20px;">
    
    @component('vendor.mail.html.panel')
        {{ $slot }}
    @endcomponent
</div>
@endcomponent