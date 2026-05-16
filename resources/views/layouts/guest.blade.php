<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CASP- Assignment Submission Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <div id="confirmation-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-gray-900/60 px-4">
            <div class="w-full max-w-md rounded-lg bg-white shadow-xl">
                <div class="p-6">
                    <h2 id="confirmation-modal-title" class="text-lg font-bold" style="color: #042C53;">Confirm Action</h2>
                    <p id="confirmation-modal-message" class="mt-2 text-sm text-gray-600">Are you sure you want to continue?</p>
                </div>
                <div class="flex justify-end gap-3 border-t border-gray-100 px-6 py-4">
                    <button type="button" id="confirmation-modal-cancel" class="rounded-lg px-4 py-2 text-sm font-bold text-gray-600 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="button" id="confirmation-modal-confirm" class="rounded-lg px-4 py-2 text-sm font-bold text-white" style="background-color: #185FA5;">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('confirmation-modal');
                const title = document.getElementById('confirmation-modal-title');
                const message = document.getElementById('confirmation-modal-message');
                const cancelButton = document.getElementById('confirmation-modal-cancel');
                const confirmButton = document.getElementById('confirmation-modal-confirm');
                let pendingForm = null;

                function closeModal() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    pendingForm = null;
                }

                document.querySelectorAll('[data-confirm-form]').forEach((button) => {
                    button.addEventListener('click', () => {
                        pendingForm = button.closest('form');
                        title.textContent = button.dataset.confirmTitle || 'Confirm Action';
                        message.textContent = button.dataset.confirmMessage || 'Are you sure you want to continue?';
                        confirmButton.textContent = button.dataset.confirmButton || 'Confirm';
                        confirmButton.style.backgroundColor = button.dataset.confirmTone === 'danger' ? '#A32D2D' : '#185FA5';
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });

                cancelButton.addEventListener('click', closeModal);
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                confirmButton.addEventListener('click', () => {
                    if (pendingForm) {
                        pendingForm.submit();
                    }
                });
            });
        </script>
    </body>
</html>
