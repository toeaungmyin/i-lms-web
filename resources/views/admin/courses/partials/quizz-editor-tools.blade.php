<div class="flex items-center justify-between px-2 py-2 border-b dark:border-gray-600">
    <div class="w-full flex flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
        <div id="quizz-editor-tools" class=" w-full flex items-center justify-between px-2 py-1">
            <div class="flex gap-2">
                <button type="button" id="add-blank" class="flex justify-center items-center p-0.5 px-2 pb-1 bg-gray-700 text-gray-100 rounded cursor-pointer hover:text-gray-50 hover:bg-gray-900 ">
                    <span class="text-xs font-semibold">blank</span>
                </button>
                <button type="button" id="add-paragraph" class="flex justify-center items-center p-0.5 px-2 pb-1 bg-gray-700 text-gray-100 rounded cursor-pointer hover:text-gray-50 hover:bg-gray-900 ">
                    <span class="text-xs font-semibold">paragraph</span>
                </button>
                <button type="button" id="add-list" class="flex justify-center items-center p-0.5 px-2 bg-gray-700 text-gray-100 rounded cursor-pointer hover:text-gray-50 hover:bg-gray-900 gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                    <span class="text-xs font-semibold uppercase">list</span>
                </button>
            </div>
            <div class="flex gap-2">
                <button type="button" id="clear" class="flex justify-center items-center p-0.5 px-2 pb-1 bg-gray-700 text-gray-100 rounded cursor-pointer hover:text-gray-50 hover:bg-gray-900 ">
                    <span class="text-xs font-semibold uppercase">clear</span>
                </button>
                <button type="button" id="undo" class="flex justify-center items-center p-0.5 px-2 pb-1 bg-gray-700 text-gray-100 rounded cursor-pointer hover:text-gray-50 hover:bg-gray-900 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-undo-2"><path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11"/></svg>
                    <span class="text-xs font-semibold sr-only">Undo</span>
                </button>
                <button type="button" id="redo" class="flex justify-center items-center p-0.5 px-2 pb-1 bg-gray-700 text-gray-100 rounded cursor-pointer hover:text-gray-50 hover:bg-gray-900 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-redo-2"><path d="m15 14 5-5-5-5"/><path d="M20 9H9.5A5.5 5.5 0 0 0 4 14.5A5.5 5.5 0 0 0 9.5 20H13"/></svg>
                    <span class="text-xs font-semibold sr-only">Redo</span>
                </button>
            </div>
        </div>
    </div>
</div>

