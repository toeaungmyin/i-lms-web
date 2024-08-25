<div class="flex flex-col bg-white p-4 rounded-md">
    @foreach ($course->assignments as $assignment)
        <div class="p-4">
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                    <span class="text-xl font-bold m-0">{{ $assignment->title }}</span>
                </div>
                <span class="flex gap-2 mt-1 text-sm font-medium text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                    {{ Carbon\Carbon::parse($assignment->due_date)->format('M/d/Y')}}
                </span>

            </div>
            <div class="flex flex-col justify-center items-center py-4">
                @php
                    $ext = pathinfo($assignment->file, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);

                    switch ($ext) {
                        case 'pdf': $icon = 'assets/icons/pdf.png';
                        break;
                        case 'doc': $icon = 'assets/icons/doc.png';
                        break;
                        case 'docx': $icon = 'assets/icons/doc.png';
                        break;
                        case 'ppt': $icon = 'assets/icons/ppt.png';
                        break;
                        case 'pptx': $icon = 'assets/icons/ppt.png';
                        break;
                        case 'zip': $icon = 'assets/icons/zip.png';
                        break;
                        default: $icon = 'assets/icons/file.png';
                    }
                @endphp
                <a class="flex flex-col justify-center items-center gap-1" href="{{ asset($assignment->file) }}" download>
                    <img src="{{ asset($icon) }}" class="aspect-square w-8 h-8 md:w-16 md:h-16" alt="">
                    <span class="text-xs text-blue-600 underline text-wrap">
                        {{ basename($assignment->file) }}
                    </span>
                    @if (Carbon\Carbon::parse($assignment->due_date)->diffInMilliseconds(Carbon\Carbon::now()) > 0)
                        <span class="text-red-500 font-semibold">(Overdue {{ Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }})</span>
                    @else
                        <span class="text-green-500 font-semibold">(Remaining {{ Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }})</span>
                    @endif
                </a>

            </div>
        </div>
    @endforeach
</div>
