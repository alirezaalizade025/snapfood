<div>
    <div wire:poll.1000ms.visible>
        {{ ($expires_at ?? $updated_at)->diff(now())->format('%d') }} day(s)
        {{ ($expires_at ?? $updated_at)->diff(now())->format('%H:%I:%S') }}
    </div>
</div>
