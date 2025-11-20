<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QLIO - Gestion des Stages</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Faire disparaître les messages après 3 secondes
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-success, .alert-error, .alert-info');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 3000);
            });
        });
    </script>
    <script src="{{ asset('js/phone-formatter.js') }}"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold">QLIO</a>
                @inject('access', 'App\\Services\\AccessManager')
                <div class="flex space-x-6">
                    @if($access->canAtLeast('dashboard', 'lecture'))
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-200 transition-colors">Tableau de bord</a>
                    @endif
                    @if($access->canAtLeast('users', 'lecture'))
                        <a href="{{ route('users') }}" class="hover:text-blue-200 transition-colors">Utilisateurs</a>
                    @endif
                    @if($access->canAtLeast('societes', 'lecture'))
                        <a href="{{ route('societes') }}" class="hover:text-blue-200 transition-colors">Entreprises</a>
                    @endif
                    @if($access->canAtLeast('stages', 'lecture'))
                        <a href="{{ route('stages') }}" class="hover:text-blue-200 transition-colors">Stages</a>
                    @endif
                    @if($access->canAtLeast('nomenclatures', 'lecture'))
                        <a href="{{ route('nomenclatures') }}" class="hover:text-blue-200 transition-colors">Nomenclatures</a>
                    @endif
                    @if($access->canAtLeast('type-stages', 'lecture'))
                        <a href="{{ route('type-stages') }}" class="hover:text-blue-200 transition-colors">Types de stages</a>
                    @endif
                    @if($access->canAtLeast('groupes', 'lecture'))
                        <a href="{{ route('groupes') }}" class="hover:text-blue-200 transition-colors">Groupes & droits</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @include('components.flash-messages')
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
