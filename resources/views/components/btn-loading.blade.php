@push('post-scripts')
    <script>
        const startLoading = (status,className) => {
                const submitBtn = document.getElementById(`${className}`);
                const loader = document.querySelector(`#${className} #loader`);
                if(status){
                    submitBtn.classList.add('flex','gap-2','cursor-not-allowed','opacity-50');
                    loader && loader.classList.remove('hidden');
                }else{
                    submitBtn.classList.remove('flex','gap-2','cursor-not-allowed','opacity-50');
                    loader && loader.classList.add('hidden');
                }
            }
    </script>
@endpush
