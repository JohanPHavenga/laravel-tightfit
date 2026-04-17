@if(Session::has('success'))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-6 right-6 z-50 flex items-start gap-3 bg-white border border-gray-200 shadow-xl rounded-xl px-5 py-4 max-w-sm"
    role="alert"
>
    <div class="flex-shrink-0 mt-0.5">
        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-semibold text-gray-900">Message sent!</p>
        <p class="text-sm text-gray-500 mt-0.5">{{ Session::get('success') }}</p>
    </div>
    <button @click="show = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors ml-2">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif
