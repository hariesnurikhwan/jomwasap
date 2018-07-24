<div class="content">
    <div class="title">Something went wrong.</div>

    @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
        <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

        <!-- Sentry JS SDK 2.1.+ required -->
        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
            Raven.showReportDialog({
                eventId: '{{ Sentry::getLastEventID() }}',
                // use the public DSN (dont include your secret!)
                dsn: 'https://e9ebbd88548a441288393c457ec90441@sentry.io/3235',
                @auth
                user: {
                    'name': auth()->user()->name,
                    'email': auth()->user()->email,
                }
                @endauth
            });
        </script>
    @endif
</div>
