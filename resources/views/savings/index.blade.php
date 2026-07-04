<x-spendwise title="Target Tabungan">
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; }
    .page-header p { font-size:12px; color:var(--text-muted); }

    /* Add form */
    .add-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem; margin-bottom:1.25rem; box-shadow:var(--shadow); }
    .add-card h2 { font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:1rem; }
    .add-form-grid { display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:10px; align-items:flex-end; }
    .add-form-grid-2 { display:grid; grid-template-columns:auto 1fr 1fr; gap:10px; align-items:flex-end; margin-top:10px; }

    /* Icon picker */
    .icon-options { display:flex; gap:6px; flex-wrap:wrap; margin-top:6px; }
    .icon-btn { width:32px; height:32px; border:1.5px solid var(--border); border-radius:7px; background:var(--bg-input); cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; transition:all .15s; }
    .icon-btn:hover, .icon-btn.selected { border-color:var(--accent); background:rgba(108,99,255,.1); }
    #selected-icon { display:none; }

    /* Goals grid */
    .goals-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:16px; }
    .goal-card { background:var(--bg-card); border-radius:12px; border:1px solid var(--border); padding:1.25rem; box-shadow:var(--shadow); position:relative; transition:transform .15s; }
    .goal-card:hover { transform:translateY(-2px); }
    .goal-card.completed { border-color:rgba(74,222,128,.3); background:rgba(74,222,128,.03); }

    .goal-header { display:flex; align-items:center; gap:10px; margin-bottom:1rem; }
    .goal-icon { font-size:26px; width:44px; height:44px; background:var(--bg-row); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .goal-name { font-size:14px; font-weight:600; color:var(--text-primary); }
    .goal-deadline { font-size:11px; color:var(--text-muted); margin-top:2px; }

    .goal-amounts { display:flex; justify-content:space-between; margin-bottom:8px; }
    .goal-current { font-size:18px; font-weight:700; color:var(--accent); }
    .goal-target { font-size:12px; color:var(--text-muted); align-self:flex-end; }

    .goal-progress-bar { height:8px; background:var(--border); border-radius:10px; overflow:hidden; margin-bottom:8px; }
    .goal-progress-fill { height:100%; border-radius:10px; transition:width .5s ease; }
    .goal-pct { font-size:12px; font-weight:600; margin-bottom:12px; }

    .goal-remaining { font-size:12px; color:var(--text-muted); margin-bottom:12px; }

    .goal-actions { display:flex; gap:8px; align-items:center; }
    .goal-update-form { display:flex; gap:6px; flex:1; }
    .goal-update-input { flex:1; background:var(--bg-input); border:1px solid var(--border); border-radius:6px; padding:6px 10px; font-size:12px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; min-width:0; }
    .goal-update-input:focus { border-color:var(--accent); }
    .btn-update { background:var(--accent); color:#fff; border:none; border-radius:6px; padding:6px 12px; font-size:11px; cursor:pointer; font-family:'Poppins',sans-serif; font-weight:500; white-space:nowrap; }
    .btn-delete { background:none; border:none; color:var(--danger); font-size:12px; cursor:pointer; padding:4px; border-radius:5px; }
    .btn-delete:hover { background:var(--badge-out-bg); }
    .btn-delete svg { width:14px; height:14px; }
    .btn-primary { background:#1B4F8C; color:#fff; border:none; border-radius:7px; padding:7px 14px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-primary:hover { background:var(--accent); transform: translateY(-1px); }

    .completed-badge { position:absolute; top:12px; right:12px; background:rgba(74,222,128,.15); color:var(--success); border:1px solid rgba(74,222,128,.2); border-radius:20px; padding:3px 10px; font-size:10px; font-weight:600; }

    .empty-state { text-align:center; padding:4rem; color:var(--text-muted); }
    .empty-state .empty-icon { font-size:48px; margin-bottom:12px; }
    .empty-state p { font-size:13px; }

    .sw-select { background:var(--bg-input); border:1px solid var(--border); border-radius:7px; padding:7px 10px; font-size:12px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; }
    .sw-select:hover { background:var(--bg-row); border-color:var(--accent);}
    .sw-input { background:var(--bg-input); border:1px solid var(--border); border-radius:7px; padding:7px 10px; font-size:12px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; }
    .sw-input:hover { background:var(--bg-row); border-color:var(--accent);}
</style>

<div class="page-header">
    <p>{{ $goals->count() }} target tabungan aktif</p>
</div>

{{-- Form Tambah --}}
<div class="add-card">
    <h2>➕ Tambah Target Tabungan Baru</h2>
    <form method="POST" action="{{ route('savings.store') }}">
        @csrf

        {{-- Icon picker --}}
        <div class="sw-form-group">
            <label class="sw-label">Pilih Ikon</label>
            <div class="icon-options">
                @foreach(['🎯','🏠','✈️','📱','🚗','💍','🎓','💻','👜','🏖️','🎮','💰'] as $ic)
                    <button type="button" class="icon-btn {{ $ic=='🎯'?'selected':'' }}"
                        onclick="selectIcon('{{ $ic }}', this)">{{ $ic }}</button>
                @endforeach
            </div>
            <input type="hidden" name="icon" id="selected-icon" value="🎯">
        </div>

        <div class="add-form-grid">
            <div class="sw-form-group">
                <label class="sw-label">Nama Target</label>
                <input type="text" name="name" class="sw-input" placeholder="Beli laptop, DP motor..." required value="{{ old('name') }}">
                @error('name')<p class="sw-error">{{ $message }}</p>@enderror
            </div>
            <div class="sw-form-group">
                <label class="sw-label">Target (Rp)</label>
                <input type="number" name="target_amount" class="sw-input" placeholder="5000000" required value="{{ old('target_amount') }}">
                @error('target_amount')<p class="sw-error">{{ $message }}</p>@enderror
            </div>
            <div class="sw-form-group">
                <label class="sw-label">Sudah Terkumpul (Rp)</label>
                <input type="number" name="current_amount" class="sw-input" placeholder="0" value="{{ old('current_amount',0) }}">
            </div>
            <div class="sw-form-group">
                <label class="sw-label">Deadline <span style="color:var(--text-muted)">(opsional)</span></label>
                <input type="date" name="deadline" class="sw-input" value="{{ old('deadline') }}"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:4px">Simpan Target</button>
    </form>
</div>

{{-- Goals List --}}
@if($goals->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">🎯</div>
        <p>Belum ada target tabungan.<br>Tambahkan target pertamamu di atas!</p>
    </div>
@else
    <div class="goals-grid">
        @foreach($goals as $goal)
        @php
            $pct   = $goal->progress_percent;
            $color = $pct >= 100 ? 'var(--success)' : ($pct >= 75 ? 'var(--warning)' : 'var(--accent)');
            $sisa  = $goal->deadline ? \Carbon\Carbon::parse($goal->deadline)->diffForHumans() : null;
        @endphp
        <div class="goal-card {{ $goal->is_completed?'completed':'' }}">
            @if($goal->is_completed)
                <div class="completed-badge">✓ Tercapai!</div>
            @endif

            <div class="goal-header">
                <div class="goal-icon">{{ $goal->icon }}</div>
                <div>
                    <div class="goal-name">{{ $goal->name }}</div>
                    @if($goal->deadline)
                        <div class="goal-deadline">🗓 Deadline {{ $goal->deadline->format('d M Y') }} ({{ $sisa }})</div>
                    @endif
                </div>
            </div>

            <div class="goal-amounts">
                <div class="goal-current">Rp {{ number_format($goal->current_amount,0,',','.') }}</div>
                <div class="goal-target">dari Rp {{ number_format($goal->target_amount,0,',','.') }}</div>
            </div>

            <div class="goal-progress-bar">
                <div class="goal-progress-fill" style="width:{{ $pct }}%;background:{{ $color }}"></div>
            </div>

            <div class="goal-pct" style="color:{{ $color }}">{{ $pct }}% tercapai</div>

            @if(!$goal->is_completed)
                <div class="goal-remaining">
                    Kurang <b style="color:var(--text-primary)">Rp {{ number_format($goal->remaining,0,',','.') }}</b> lagi
                </div>
            @endif

            <div class="goal-actions">
                @if(!$goal->is_completed)
                <form method="POST" action="{{ route('savings.update',$goal) }}" class="goal-update-form">
                    @csrf @method('PUT')
                    <input type="number" name="current_amount" class="goal-update-input"
                        placeholder="Update jumlah (Rp)"
                        value="{{ $goal->current_amount }}" min="0">
                    <button type="submit" class="btn-update">Update</button>
                </form>
                @else
                    <span style="font-size:12px;color:var(--success);font-weight:600;flex:1">🎉 Target berhasil dicapai!</span>
                @endif

                <form method="POST" action="{{ route('savings.destroy',$goal) }}" onsubmit="return confirm('Hapus target ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif

<script>
function selectIcon(icon, btn) {
    document.querySelectorAll('.icon-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    document.getElementById('selected-icon').value = icon;
}
</script>
</x-spendwise>
