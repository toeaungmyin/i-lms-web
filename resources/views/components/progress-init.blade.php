@push('post-scripts')
    <script>
        class ProgressBar {
            constructor(key) {
                this.key = key;
                this.progressContainer = document.getElementById(`progress-container-${key}`);
                this.fileUploadProgress = document.getElementById(`file-upload-progress-${key}`);
                this.progressValue = document.getElementById(`progress-value-${key}`);
                this.progressValue.innerText = '0%';
                this.fileUploadProgress.style.transform = 'translateX(-100%)';
            }

            updateProgress(progress) {

                const translateXValue = 100 - progress;
                this.fileUploadProgress.style.transform = `translateX(-${translateXValue}%)`;
                this.fileUploadProgress.style.animation = `scroll 0.5s ease-in-out`;
                this.progressValue.innerText = `${progress}%`;

                if (progress === 100) {
                    this.progressValue.innerText = 'completed';
                    setTimeout(() => {
                        this.hideProgress();
                    }, 1500);
                }
            }

            showProgress() {
                this.progressContainer.classList.remove('hidden');
                this.progressContainer.classList.add('flex');
            }

            hideProgress() {
                this.progressContainer.classList.add('hidden');
                this.progressContainer.classList.remove('flex');
            }
        }
    </script>
@endpush
