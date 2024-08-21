<div class="flex flex-col">
    @foreach ($course->chapters as $chapter)
        <div class="flex flex-col gap-2 p-4">
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-text"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="M8 11h8"/><path d="M8 7h6"/></svg>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $chapter->title }}</h1>
                </div>
                <span class="flex gap-2 mt-1 text-sm font-medium text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                    {{ Carbon\Carbon::parse($chapter->created_at)->format('M/d/Y')}}
                </span>
            </div>
            <p class="text-gray-500 font-medium">{{ $chapter->description }}</p>
            <div class="flex justify-center py-4">
                @foreach (json_decode($chapter->assets) as $item)
                    <?php
                        $ext = pathinfo($item, PATHINFO_EXTENSION);
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
                    ?>
                    <a class="flex flex-col justify-center items-center gap-1" href="{{ asset($item) }}" download>
                        <img src="{{ asset($icon) }}" class="aspect-square w-8 h-8 md:w-16 md:h-16" alt="">
                        <span class="text-xs text-blue-600 underline text-wrap">
                            {{ basename($item) }}
                        </span>
                    </a>
                @endforeach
            </div>
            <div class="border-b-2 border-gray-300">

            </div>
        </div>
    @endforeach
</div>
