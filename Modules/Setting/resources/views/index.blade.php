@extends('layouts.portal')
@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')

@section('content')

@if(session('success'))
<div class="alert alert-success mb-4 d-flex align-items-center" style="gap:12px;">
    <i class="fas fa-check-circle mt-1 flex-shrink-0"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

<div class="card">
    <div class="card-header border-bottom-0 pb-0">
        <ul class="nav nav-tabs" id="settingTabs" role="tablist" style="border-bottom: 2px solid #e2e8f0;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-toggle="tab" data-target="#general" type="button" role="tab" style="font-weight:600; color:#475569; border:none; border-bottom:2px solid transparent; margin-bottom:-2px;">Umum</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="role-tab" data-toggle="tab" data-target="#role" type="button" role="tab" style="font-weight:600; color:#475569; border:none; border-bottom:2px solid transparent; margin-bottom:-2px;">Role Menu</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="appearance-tab" data-toggle="tab" data-target="#appearance" type="button" role="tab" style="font-weight:600; color:#475569; border:none; border-bottom:2px solid transparent; margin-bottom:-2px;">Tampilan</button>
            </li>
        </ul>
    </div>
    
    <div class="card-body">
        <form action="{{ route('setting.update') }}" method="POST">
            @csrf
            
            <div class="tab-content" id="settingTabsContent">
                {{-- GENERAL SETTINGS --}}
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <h5 class="mb-3 font-weight-bold" style="color:#1e293b;">Pengaturan Umum</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Nama Aplikasi</label>
                            <input type="text" name="app_name" class="form-control" value="{{ setting('app_name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Deskripsi Aplikasi</label>
                            <input type="text" name="app_desc" class="form-control" value="{{ setting('app_desc') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Nama Perusahaan</label>
                            <input type="text" name="company_name" class="form-control" value="{{ setting('company_name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Email Perusahaan</label>
                            <input type="email" name="company_email" class="form-control" value="{{ setting('company_email') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">No. Telepon</label>
                            <input type="text" name="company_phone" class="form-control" value="{{ setting('company_phone') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label font-weight-bold">Alamat Perusahaan</label>
                            <textarea name="company_address" class="form-control" rows="2">{{ setting('company_address') }}</textarea>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    <h5 class="mb-3 font-weight-bold" style="color:#1e293b;">Nomor Rekening</h5>
                    <p class="text-muted" style="font-size:13px;">Daftar rekening bank untuk pembayaran. Anda bisa menambah lebih dari satu.</p>
                    
                    <div id="bankAccountsContainer">
                        @php
                            $banks = setting('bank_accounts', []);
                            if(!is_array($banks)) $banks = [];
                        @endphp
                        @foreach($banks as $index => $bank)
                        <div class="row bank-row mb-2">
                            <div class="col-md-3">
                                <input type="text" name="bank_accounts[{{ $index }}][bank_name]" class="form-control form-control-sm" placeholder="Nama Bank (cth: BCA)" value="{{ $bank['bank_name'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="bank_accounts[{{ $index }}][account_number]" class="form-control form-control-sm" placeholder="No Rekening" value="{{ $bank['account_number'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="bank_accounts[{{ $index }}][account_name]" class="form-control form-control-sm" placeholder="Atas Nama" value="{{ $bank['account_name'] ?? '' }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm btn-remove-bank"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="btnAddBank"><i class="fas fa-plus"></i> Tambah Rekening</button>
                </div>
                
                {{-- ROLE MENU SETTINGS --}}
                <div class="tab-pane fade" id="role" role="tabpanel">
                    <h5 class="mb-3 font-weight-bold" style="color:#1e293b;">Role Menu Management</h5>
                    <p class="text-muted" style="font-size:13px;">Pilih menu mana saja yang boleh diakses oleh tiap role pengguna.</p>
                    
                    @php
                        $rolePermissions = setting('role_permissions', []);
                        if(!is_array($rolePermissions)) $rolePermissions = [];
                        $availableMenus = [
                            'dashboard' => 'Dashboard',
                            'billing' => 'Billing & Invoice',
                            'recruitment' => 'Recruitment & Pelamar',
                            'project' => 'Project Management',
                            'finance' => 'Finance & Kas',
                            'setting' => 'Pengaturan Sistem'
                        ];
                        $roles = ['director', 'admin', 'staff', 'hr', 'finance'];
                    @endphp
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="font-size:13px;">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th>Role Pengguna</th>
                                    <th>Hak Akses Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td class="font-weight-bold align-middle" style="text-transform: capitalize;">{{ $role }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap" style="gap:15px;">
                                            @foreach($availableMenus as $menuKey => $menuLabel)
                                                @php
                                                    $isChecked = isset($rolePermissions[$role]) && in_array($menuKey, $rolePermissions[$role]);
                                                @endphp
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="perm_{{ $role }}_{{ $menuKey }}" name="role_permissions[{{ $role }}][]" value="{{ $menuKey }}" {{ $isChecked ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="perm_{{ $role }}_{{ $menuKey }}">{{ $menuLabel }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- APPEARANCE SETTINGS --}}
                <div class="tab-pane fade" id="appearance" role="tabpanel">
                    <h5 class="mb-3 font-weight-bold" style="color:#1e293b;">Pengaturan Tampilan</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Tema Aplikasi</label>
                            <select name="theme_mode" class="form-control">
                                <option value="light" {{ setting('theme_mode') == 'light' ? 'selected' : '' }}>Terang (Light)</option>
                                <option value="dark" {{ setting('theme_mode') == 'dark' ? 'selected' : '' }}>Gelap (Dark)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">Warna Utama (Primary Color)</label>
                            <input type="color" name="primary_color" class="form-control" value="{{ setting('primary_color', '#4e73df') }}" style="height:38px;">
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="mt-4 mb-4">
            <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold"><i class="fas fa-save mr-2"></i> Simpan Pengaturan</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab logic
        const tabs = document.querySelectorAll('.nav-link[data-toggle="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.borderBottomColor = 'transparent';
                    t.style.color = '#475569';
                });
                
                document.querySelectorAll('.tab-pane').forEach(p => {
                    p.classList.remove('show', 'active');
                });
                
                this.classList.add('active');
                this.style.borderBottomColor = '#2563eb';
                this.style.color = '#2563eb';
                
                const target = document.querySelector(this.getAttribute('data-target'));
                target.classList.add('show', 'active');
            });
        });
        
        // Initial tab style setup
        const activeTab = document.querySelector('.nav-link.active');
        if(activeTab) {
            activeTab.style.borderBottomColor = '#2563eb';
            activeTab.style.color = '#2563eb';
        }

        // Bank Accounts Dynamic Fields
        const btnAddBank = document.getElementById('btnAddBank');
        const container = document.getElementById('bankAccountsContainer');
        let bankIndex = document.querySelectorAll('.bank-row').length;

        btnAddBank.addEventListener('click', function() {
            const html = `
                <div class="row bank-row mb-2">
                    <div class="col-md-3">
                        <input type="text" name="bank_accounts[${bankIndex}][bank_name]" class="form-control form-control-sm" placeholder="Nama Bank (cth: BCA)">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="bank_accounts[${bankIndex}][account_number]" class="form-control form-control-sm" placeholder="No Rekening">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="bank_accounts[${bankIndex}][account_name]" class="form-control form-control-sm" placeholder="Atas Nama">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm btn-remove-bank"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            bankIndex++;
        });

        container.addEventListener('click', function(e) {
            if(e.target.closest('.btn-remove-bank')) {
                e.target.closest('.bank-row').remove();
            }
        });
    });
</script>
@endsection
