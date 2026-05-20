@extends('layouts.portal')
@section('title', 'Coming Soon')
@section('page-title', 'Segera Hadir')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center" style="margin-top: 50px;">
        <div style="font-size: 80px; color: #cbd5e1; margin-bottom: 20px;">
            <i class="fas fa-person-digging"></i>
        </div>
        <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 16px;">Modul Sedang Dikembangkan</h2>
        <p style="color: #64748b; font-size: 16px; margin-bottom: 30px; line-height: 1.6;">
            Fitur <strong>{{ request()->query('feature', 'ini') }}</strong> saat ini masih dalam tahap perancangan dan pengembangan. <br>
            Tim Fluxa sedang berupaya keras untuk segera menghadirkan fitur ini untuk Anda.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-fluxa-primary" style="padding: 12px 24px; border-radius: 99px;">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
