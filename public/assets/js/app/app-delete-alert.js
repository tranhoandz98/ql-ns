function onDeleteItem(id) {
    const form = document.querySelector('#delete-form-' + id); // Get the closest form element
    Swal.fire({
        title: "{{ __('messages.notify') }}",
        text: `{{ __('messages.are_you_sure_delete') }}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "{{ __('messages.delete') }}",
        cancelButtonText: "{{ __('messages.cancel') }}",
        customClass: {
            confirmButton: "btn btn-danger waves-effect waves-light",
            cancelButton: "btn btn-secondary waves-effect waves-light",
            action: 'gap-4'
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // Submit the form if confirmed
        }
    });
}