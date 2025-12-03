@if(session('errormMessage'))
<script>
    window.assEventListener('load', function() {

    Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "Something went wrong!",
    footer: '<a href="#">Why do I have this issue?</a>'
    });

});
</script>
@endif


@if(session('save_user'))
<script>
    window.assEventListener('load', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('errormMessage') }}',
            confirmButtonColor: '#3085d6',
        });
    });
</script>
@endif
            