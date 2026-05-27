<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} PT Fluxa Tritama Indonesia. <br>
<a href="https://www.fluxa.co.id" style="color: #38bdf8; text-decoration: none;">www.fluxa.co.id</a>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
