
<div id="alert" class="fixed z-10 overflow-hidden max-w-md top-2 right-4 flex gap-2 p-4 px-6 transition-transform transform translate-x-[150%] duration-500 rounded-md border">
    <svg xmlns="http://www.w3.org/2000/svg" id="success" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
    <svg xmlns="http://www.w3.org/2000/svg" id="error" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
    <svg xmlns="http://www.w3.org/2000/svg" id="warning" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
    <div id="message">
    </div>
    <div id="progress" class="absolute bottom-0 left-0 h-1 transition-all duration-100"></div>
</div>


@push('post-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('message'))
                showAlertMessage(@json(session('message')))
            @endif
        });

        const showAlertMessage = (message) => {
            const alertBox = document.getElementById('alert');
            const messageBox = document.getElementById('message');
            const progress = document.getElementById('progress');

            const statusClasses = {
                success: {
                    add: ['text-green-500', 'border-green-300', 'bg-green-100'],
                    progressAdd: ['bg-green-400'],
                    remove: ['text-amber-500', 'border-amber-300', 'bg-amber-100', 'text-red-500', 'border-red-300', 'bg-red-100'],
                    progressRemove: ['bg-amber-400', 'bg-red-400']
                },
                warning: {
                    add: ['text-amber-500', 'border-amber-300', 'bg-amber-100'],
                    progressAdd: ['bg-amber-400'],
                    remove: ['text-green-500', 'border-green-300', 'bg-green-100', 'text-red-500', 'border-red-300', 'bg-red-100'],
                    progressRemove: ['bg-green-400', 'bg-red-400']
                },
                error: {
                    add: ['text-red-500', 'border-red-300', 'bg-red-100'],
                    progressAdd: ['bg-red-400'],
                    remove: ['text-green-500', 'border-green-300', 'bg-green-100', 'text-amber-500', 'border-amber-300', 'bg-amber-100'],
                    progressRemove: ['bg-green-400', 'bg-amber-400']
                }
            };

            if (message.status in statusClasses) {
                const { add, progressAdd, remove, progressRemove } = statusClasses[message.status];

                alertBox.classList.add(...add);
                progress.classList.add(...progressAdd);

                alertBox.classList.remove(...remove);
                progress.classList.remove(...progressRemove);

                Object.keys(statusClasses).forEach(key => {
                    const element = document.getElementById(key);
                    if (element) {
                        if (key === message.status) {
                            element.classList.remove('hidden');
                        } else {
                            element.classList.add('hidden');
                        }
                    } else {
                        console.error(`Element with id "${key}" not found.`);
                    }
                });

            }

            if (message.content === 'Validation Error' && message.log) {

                messageBox.innerHTML = '';
                messageBox.innerHTML += `<span class="font-semibold">${message.content}</span>`;
                messageBox.innerHTML += `
                    <ul id="messageList" class="mt-1.5 list-disc list-inside">

                    </ul>
                `;

                const messageList = document.getElementById('messageList');

                for (let key in message.log) {
                    if (message.log.hasOwnProperty(key)) {
                        messageList.innerHTML += `
                            <li>${message.log[key]}</li>
                        `;
                    }
                }
            }
            else {
                messageBox.innerHTML = `<span class="font-semibold">${message.content}</span>`;
            }

            alertBox.classList.remove('translate-x-[150%]');
            alertBox.classList.add('translate-x-0');

            let width = 0;
            let paused = false;
            let elapsedTime = 0;
            const startTime = Date.now();
            const interval = setInterval(() => {
                if (!paused) {
                    elapsedTime = Date.now() - startTime;
                    if (width >= 100) {
                        clearInterval(interval);
                    } else {
                        width = (elapsedTime / 5000) * 100;
                        progress.style.width = width + '%';
                    }
                }
            }, 30);

            let alertTimeout = setTimeout(() => {
                alertBox.classList.remove('translate-x-0');
                alertBox.classList.add('translate-x-[150%]');
            }, 5000);

            alertBox.addEventListener('mouseenter', () => {
                paused = true;
                clearTimeout(alertTimeout);
            });

            alertBox.addEventListener('mouseleave', () => {
                paused = false;
                const remainingTime = 5000 - elapsedTime;
                alertTimeout = setTimeout(() => {
                    alertBox.classList.remove('translate-x-0');
                    alertBox.classList.add('translate-x-[150%]');
                }, remainingTime);
            });
        }
    </script>
@endpush
