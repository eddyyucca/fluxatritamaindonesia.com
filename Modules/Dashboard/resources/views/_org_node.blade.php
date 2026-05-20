<div class="org-node flex flex-col mt-4">
    <div class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-lg p-3 w-fit">
        <div class="avatar w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
            <span class="text-white font-bold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-white">{{ $user->name }}</h4>
            <p class="text-xs text-slate-400">{{ $user->position ?? '—' }}</p>
        </div>
        @if($user->org_level)
            <span class="ml-4 text-[10px] px-2 py-0.5 rounded-full bg-blue-500/15 text-blue-400 border border-blue-500/25">Level {{ $user->org_level }}</span>
        @endif
    </div>
    
    @if($user->subordinates->count() > 0)
        <div class="pl-8 border-l-2 border-white/10 ml-5 mt-2 space-y-2">
            @foreach($user->subordinates as $subordinate)
                @include('dashboard::_org_node', ['user' => $subordinate])
            @endforeach
        </div>
    @endif
</div>
