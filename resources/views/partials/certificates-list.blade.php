@if(isset($certificates) && $certificates->count())
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($certificates as $certificate)
      <div class="bg-white shadow rounded p-4 flex flex-col">
        <div class="font-bold text-lg mb-1">{{ $certificate->title }}</div>
        <div class="mb-2 text-gray-700">{{ $certificate->event->title ?? '' }}</div>
        <div class="mb-2 text-sm text-gray-500">{{ __('Issued:') }} {{ $certificate->created_at->format('d/m/Y') }}</div>
        <a href="{{ route('certificates.show', $certificate) }}" class="btn-primary mt-auto text-center">{{ __('View') }}</a>
      </div>
    @endforeach
  </div>
@else
  <div class="text-center text-gray-400">{{ __('No certificates found.') }}</div>
@endif
