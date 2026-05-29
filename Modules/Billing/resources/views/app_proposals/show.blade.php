@extends('layouts.portal')
@section('title', $app_proposal->proposal_number)
@section('page-title', 'Detail Proposal Aplikasi')

@section('topbar-actions')
<li class="nav-item">
    <div class="d-flex align-items-center" style="gap:6px;">
        @if($app_proposal->status === 'draft')
            <a href="{{ route('billing.app_proposals.edit', $app_proposal) }}" class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-pen mr-1"></i> Edit
            </a>
            <form method="POST" action="{{ route('billing.app_proposals.submit', $app_proposal) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-primary">
                    <i class="fas fa-paper-plane mr-1"></i> Ajukan Persetujuan
                </button>
            </form>
        @endif
        @if($app_proposal->status === 'sent' && Auth::user()->isDirector())
            <a href="{{ route('billing.app_proposals.edit', $app_proposal) }}" class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-pen mr-1"></i> Edit
            </a>
            <button type="button" class="btn btn-sm btn-fluxa-success" onclick="openApproveModal()">
                <i class="fas fa-check mr-1"></i> Setujui
            </button>
            <button type="button" class="btn btn-sm btn-fluxa-danger" onclick="openRejectModal()">
                <i class="fas fa-xmark mr-1"></i> Tolak
            </button>
        @endif
        @if(in_array($app_proposal->status, ['approved', 'rejected']) && Auth::user()->isDirector())
            <a href="{{ route('billing.app_proposals.edit', $app_proposal) }}" class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-pen mr-1"></i> Edit
            </a>
            <form method="POST" action="{{ route('billing.app_proposals.revert', $app_proposal) }}" class="d-inline"
                  data-confirm="Kembalikan proposal ini ke Draft?" data-confirm-icon="question" data-confirm-btn="Ya, Kembalikan">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-secondary" style="color:#d97706!important;">
                    <i class="fas fa-rotate-left mr-1"></i> Kembalikan ke Draft
                </button>
            </form>
        @endif
        
        <a href="{{ route('billing.app_proposals.print', $app_proposal) }}" class="btn btn-sm btn-fluxa-secondary" target="_blank">
            <i class="fas fa-print mr-1" style="color:#2563eb;"></i> Cetak / Print Proposal
        </a>

        @if($app_proposal->status === 'draft')
        <form method="POST" action="{{ route('billing.app_proposals.destroy', $app_proposal) }}" class="d-inline"
              data-confirm="Hapus proposal ini secara permanen?" data-confirm-icon="warning" data-confirm-btn="Ya, Hapus">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-icon btn-fluxa-secondary" title="Hapus" style="color:#ef4444!important;">
                <i class="fas fa-trash" style="font-size:11px;"></i>
            </button>
        </form>
        @endif
    </div>
</li>
@endsection

@section('content')

{{-- Status bar --}}
@php
    $color = $app_proposal->status_color;
    $alertMap = ['emerald'=>'alert-success','amber'=>'alert-warning','red'=>'alert-danger','slate'=>'alert-secondary','blue'=>'alert-info'];
    $iconMap  = ['emerald'=>'fa-circle-check','amber'=>'fa-clock','red'=>'fa-circle-xmark','slate'=>'fa-file','blue'=>'fa-stamp'];
@endphp
<div class="alert {{ $alertMap[$color] ?? 'alert-secondary' }} mb-4" style="gap:12px;">
    <div class="d-flex align-items-center justify-content-between" style="gap:12px;">
        <div class="d-flex align-items-center" style="gap:10px;">
            <i class="fas {{ $iconMap[$color] ?? 'fa-file' }}"></i>
            <div>
                <strong>Status: {{ $app_proposal->status_label }}</strong>
                @if($app_proposal->approved_at)
                <span style="font-size:12px;opacity:.75;margin-left:8px;">
                    &mdash; {{ $app_proposal->approved_at->isoFormat('D MMMM YYYY') }} oleh {{ $app_proposal->approver->name ?? '&mdash;' }}
                </span>
                @endif
            </div>
        </div>
        <span style="font-size:11px;opacity:.7;white-space:nowrap;">
            {{ $app_proposal->creator->name }} &middot; {{ $app_proposal->created_at->isoFormat('D MMM YYYY') }}
        </span>
    </div>
    @if($app_proposal->director_notes)
    <div style="margin-top:10px;padding:10px 14px;background:rgba(0,0,0,0.05);border-radius:8px;font-size:12px;line-height:1.6;border-left:3px solid rgba(0,0,0,0.15);">
        <i class="fas fa-comment-dots mr-1" style="opacity:.6;"></i>
        <strong>Catatan Director:</strong> {{ $app_proposal->director_notes }}
    </div>
    @endif
</div>

<div class="row">
    {{-- ── DOCUMENT PREVIEW ── --}}
    <div class="col-lg-8 mb-4">
        <div class="card">
            {{-- Doc header --}}
            <div style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);border-radius:12px 12px 0 0;">
                <div class="p-4 d-flex align-items-start justify-content-between" style="gap:16px;">
                    <div>
                        <p style="font-size:20px;font-weight:900;color:#fff;letter-spacing:-0.5px;margin-bottom:4px;">PROPOSAL APLIKASI</p>
                        <p style="color:#60a5fa;font-family:monospace;font-size:13px;font-weight:700;margin-bottom:0;">{{ $app_proposal->proposal_number }}</p>
                    </div>
                </div>
            </div>

            {{-- Doc content --}}
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div style="background:#f8fafc;border-radius:10px;padding:16px;height:100%;">
                            <p style="font-size:9px;color:#94a3b8;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">Ditujukan Kepada</p>
                            <p style="color:#1e293b;font-weight:700;font-size:14px;margin-bottom:4px;">{{ $app_proposal->client->name }}</p>
                            @if($app_proposal->client->address)
                            <p style="color:#64748b;font-size:12px;margin-bottom:2px;">{{ $app_proposal->client->address }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="background:#f8fafc;border-radius:10px;padding:16px;height:100%;">
                            <p style="font-size:9px;color:#94a3b8;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">Judul Proposal</p>
                            <p style="color:#1e293b;font-weight:600;font-size:14px;margin-bottom:4px;">{{ $app_proposal->cover_title }}</p>
                            @if($app_proposal->cover_subtitle)
                            <p style="color:#64748b;font-size:12px;margin-bottom:0;">{{ $app_proposal->cover_subtitle }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sections Preview --}}
                <div class="mb-4">
                    @if($app_proposal->introduction)
                        <h6 style="color:#1e293b;font-weight:700;">Pendahuluan</h6>
                        <div style="font-size:13px;color:#475569;margin-bottom:20px;">{!! $app_proposal->introduction !!}</div>
                    @endif

                    @if($app_proposal->scope_of_work)
                        <h6 style="color:#1e293b;font-weight:700;">Ruang Lingkup</h6>
                        <div style="font-size:13px;color:#475569;margin-bottom:20px;">{!! $app_proposal->scope_of_work !!}</div>
                    @endif
                </div>

                {{-- Items table --}}
                <h6 style="color:#1e293b;font-weight:700;margin-bottom:12px;">Rincian Investasi</h6>
                <div class="table-responsive mb-4" style="border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;">
                    <table class="table mb-0" style="font-size:13px;">
                        <thead>
                            <tr style="background:#1e293b;">
                                <th style="color:#cbd5e1;border:none;width:40px;">No</th>
                                <th style="color:#cbd5e1;border:none;">Modul / Item</th>
                                <th style="color:#cbd5e1;border:none;text-align:right;">Investasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($app_proposal->items as $i => $item)
                            <tr>
                                <td style="color:#94a3b8;text-align:center;">{{ $i + 1 }}</td>
                                <td style="color:#334155;">
                                    <strong>{{ $item->item_name }}</strong>
                                    @if($item->description)
                                        <br><small style="color:#64748b;">{{ $item->description }}</small>
                                    @endif
                                </td>
                                <td style="color:#1e293b;font-weight:600;text-align:right;white-space:nowrap;vertical-align:top;">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="border-top:2px solid #cbd5e1;background:#f8fafc;">
                            <tr>
                                <td colspan="2" style="text-align:right;font-weight:700;color:#475569;font-size:13px;">TOTAL INVESTASI</td>
                                <td style="text-align:right;font-weight:900;color:#1e293b;font-size:16px;white-space:nowrap;">
                                    Rp {{ number_format($app_proposal->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Footer: creator + QR --}}
                <div class="d-flex align-items-end justify-content-between" style="border-top:1px solid #f1f5f9;padding-top:16px;gap:16px;">
                    <div style="font-size:12px;color:#64748b;">
                        <p style="margin-bottom:2px;">Disiapkan oleh: <strong style="color:#334155;">{{ $app_proposal->creator->name }}</strong></p>
                        @if($app_proposal->status === 'approved')
                        <div style="margin-top:10px;padding:8px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;">
                            <p style="font-size:10px;font-weight:700;color:#166534;text-transform:uppercase;margin-bottom:2px;">✓ Disetujui Director</p>
                            <p style="font-size:10px;color:#16a34a;margin-bottom:0;">{{ $app_proposal->approver->name ?? '' }} · {{ $app_proposal->approved_at?->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="text-center flex-shrink-0">
                        <div id="qrcode" style="display:inline-block;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0;padding:6px;background:#fff;"></div>
                        <p style="font-size:10px;color:#94a3b8;margin-top:4px;margin-bottom:0;">Scan untuk verifikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── RIGHT SIDEBAR ── --}}
    <div class="col-lg-4">
        {{-- Profit split --}}
        @if(Auth::user()->isDirector() || $app_proposal->created_by === Auth::id())
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center" style="gap:8px;">
                <i class="fas fa-chart-pie" style="color:#2563eb;font-size:13px;"></i>
                <h6 class="card-title mb-0">Pembagian Keuntungan</h6>
            </div>
            <div class="card-body p-0">
                <div style="padding:12px 16px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#64748b;">Total Proyek</span>
                    <span style="font-weight:700;color:#1e293b;font-size:13px;">Rp {{ number_format($app_proposal->total, 0, ',', '.') }}</span>
                </div>
                <div style="padding:12px 16px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#92400e;font-weight:500;">Keuntungan PT <span style="font-size:11px;color:#94a3b8;">({{ $app_proposal->pt_profit_percent }}%)</span></span>
                    <span style="font-weight:600;color:#92400e;font-size:13px;">Rp {{ number_format($app_proposal->pt_profit_amount, 0, ',', '.') }}</span>
                </div>
                <div style="padding:12px 16px;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#166534;font-weight:500;">
                        {{ Auth::user()->isDirector() ? 'Bagian ' . ($app_proposal->creator->name ?? 'Staff') : 'Bagian Anda' }}
                    </span>
                    <span style="font-weight:700;color:#166534;font-size:15px;">Rp {{ number_format($app_proposal->user_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endif

        {{-- Document info --}}
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Informasi Dokumen</h6>
            </div>
            <div class="card-body" style="font-size:12px;">
                <div class="d-flex justify-content-between align-items-start mb-2" style="gap:8px;">
                    <span style="color:#64748b;flex-shrink:0;">No. Proposal</span>
                    <span style="font-family:monospace;font-weight:700;color:#1e293b;text-align:right;">{{ $app_proposal->proposal_number }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-start mb-2" style="gap:8px;">
                    <span style="color:#64748b;flex-shrink:0;">Klien</span>
                    <span style="color:#334155;text-align:right;">{{ $app_proposal->client->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Tanggal Dibuat</span>
                    <span style="color:#334155;">{{ $app_proposal->created_at->format('d/m/Y') }}</span>
                </div>
                @if($app_proposal->valid_until)
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Berlaku s/d</span>
                    <span style="{{ $app_proposal->valid_until->isPast() ? 'color:#dc2626;font-weight:700;' : 'color:#334155;' }}">
                        {{ $app_proposal->valid_until->format('d/m/Y') }}
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
new QRCode(document.getElementById("qrcode"), {
    text: "{{ route('verify.app_proposal', $app_proposal->qr_token) }}",
    width: 80, height: 80,
    colorDark: "#000000", colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.M
});

function openApproveModal() {
    Swal.fire({
        title: 'Setujui Proposal',
        html: `
            <p style="font-size:13px;color:#64748b;margin-bottom:12px;">
                Proposal <strong>{{ $app_proposal->proposal_number }}</strong> akan disetujui.
            </p>
            <textarea id="swal-notes" class="swal2-textarea" placeholder="Catatan (opsional)..." style="height:100px;font-size:13px;"></textarea>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check mr-1"></i> Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a',
        focusConfirm: false,
        preConfirm: () => {
            const notes = document.getElementById('swal-notes').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("billing.app_proposals.approve", $app_proposal) }}';
            form.innerHTML = `<input name="_token" value="{{ csrf_token() }}"><input name="director_notes" value="${notes}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function openRejectModal() {
    Swal.fire({
        title: 'Tolak Proposal',
        html: `
            <p style="font-size:13px;color:#64748b;margin-bottom:12px;">
                Proposal <strong>{{ $app_proposal->proposal_number }}</strong> akan ditolak.
            </p>
            <textarea id="swal-notes" class="swal2-textarea" placeholder="Alasan penolakan (opsional)..." style="height:100px;font-size:13px;"></textarea>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-xmark mr-1"></i> Ya, Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        focusConfirm: false,
        preConfirm: () => {
            const notes = document.getElementById('swal-notes').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("billing.app_proposals.reject", $app_proposal) }}';
            form.innerHTML = `<input name="_token" value="{{ csrf_token() }}"><input name="director_notes" value="${notes}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
