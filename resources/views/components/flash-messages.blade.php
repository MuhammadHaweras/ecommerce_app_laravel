@if(session('success'))
    <div id="flash-message"
         class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-2">
        <span>✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div id="flash-message"
         class="fixed top-4 right-4 z-50 w-full bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-2">
        <span>✕</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

<script>
    setTimeout(function() {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.style.transition = 'opacity 0.5s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 1500);
        }
    }, 3000);
</script>
