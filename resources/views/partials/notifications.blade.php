@if(session('success'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-green-600 text-white py-3 px-8 rounded shadow-lg animate-bounce" role="alert" aria-live="polite">
        <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-red-600 text-white py-3 px-8 rounded shadow-lg animate-bounce" role="alert" aria-live="assertive">
        <i class="fa fa-exclamation-triangle mr-2"></i> {{ session('error') }}
    </div>
@endif
