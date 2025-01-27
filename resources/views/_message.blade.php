<div class="container my-3 ">
    @if(!empty(session('success')))
       <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            })

            ;(async () => {
                Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}",
            })
        
            })()
       </script>
     @elseif(!empty(session('error')))
       <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            })

            ;(async () => {
                Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}",
            })
        
            })()
       </script>

    @endif
</div> 