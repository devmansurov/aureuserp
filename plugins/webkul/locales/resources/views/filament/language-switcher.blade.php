<div class="flex items-center gap-2">
    @foreach($locales as $locale)
        <a href="{{ route('admin.locale.switch', $locale->code) }}" class="flex items-center gap-1 px-1 text-sm {{ app()->getLocale() === $locale->code ? 'font-bold' : '' }}">
            <span>{{ $locale->flag }}</span>
            <span class="hidden sm:inline">{{ strtoupper($locale->code) }}</span>
        </a>
    @endforeach
</div>
