<li class="level-{{ min($user->org_level ?? 1, 5) }}">
    <div class="org-node-card">
        @if($user->org_level)
            <span class="level-badge">L{{ $user->org_level }}</span>
        @endif
        <div class="org-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h4 class="org-name">{{ $user->name }}</h4>
        <p class="org-position">{{ $user->position ?? '&mdash;' }}</p>
    </div>
    
    @if($user->subordinates->count() > 0)
        <ul>
            @foreach($user->subordinates as $subordinate)
                @include('dashboard::_org_node', ['user' => $subordinate])
            @endforeach
        </ul>
    @endif
</li>
