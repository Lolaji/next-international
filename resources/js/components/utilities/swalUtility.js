import Swal from 'sweetalert2';

export default {
    data(){
        return {
            swalOptions: {
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                button: {
                    show: true,
                    reverse: true,
                    confirmText: 'Yes, delete it!',
                    cancelText: 'No, cancel!'
                }
            }
        }
    },
    methods: {
        toast: function (message = '',type='success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: false,
            });
            Toast.fire({
                title: message,
                icon: type
            });
        },
        dialogAlert: function (title, message, icon='success') {
            Swal.fire({
                title: title, 
                text: message, 
                icon: icon,
                timer: 3000,
                showConfirmButton: false
            });
        },
        confirmAction: function (callback=null) {
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger mr-5'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: this.swalOptions.title,
            text: this.swalOptions.text,
            icon: this.swalOptions.icon,
            showCancelButton: this.swalOptions.button.show,
            confirmButtonText: this.swalOptions.button.confirmText,
            cancelButtonText: this.swalOptions.button.cancelText,
            reverseButtons: this.swalOptions.button.reverse
            }).then((result) => {
                if (result.value) {
                    callback();
                }
            });
        }
    }
}