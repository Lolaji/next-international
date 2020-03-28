<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Contacts</h3>
            </div>
            <div class="card-body">
                <contact-table 
                    ref="contacts"
                    :fields="cont_fields"
                    :opts="cont_options"
                    @edit="openForm"
                    @delete="removeContact"></contact-table>
            </div>

            <div class="card-footer">
                <div class="form-inline">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="label">Action</label>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <select name="flag" id="flag" v-model="b_action" class="form-control">
                            <option value="">-- Select Action --</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>
                    <button type="button" @click="bulkAction" v-if="b_action != ''" class="btn btn-primary mb-2">Apply</button>
                </div>
            </div>

        </div>

        <!-- Add Modals -->
        <div class="modal fade" id="contactMessageModal">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="overlay d-flex justify-content-center align-items-center" :class="{invisible: hide_overlay}">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="text-info">{{ name }}</span>'s Message</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>{{ message }}</p>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>

    import axios from 'axios';
    import 'bootstrap';
    import swalUtility from './utilities/swalUtility';
    import FormUtil from '../plugin/FormUtil';

    import contactTable from 'vue-datatables-net';
    import 'datatables.net-bs4';
    import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

    export default {
        mixins: [swalUtility, FormUtil],
        components: {contactTable},
        data() {
            return {
                _modal: null,
                hide_overlay: false,
                rowSelected: [],
                b_action: '',
                name: '',
                message: '',
                cont_options: {
                    ajax: {
                        url: '/admin/contacts',
                        dataSrc: (data) => {
                            return data;
                        }
                    },
                    // data: this.mailingList,
                    dom: "ftr<'row vdtnet-footer'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'pl>>",
                    processing: true,
                    searching: true,
                    lengthChange: true,
                    autoWidth: true,
                    ordering: true,
                    serverSide: false,
                    saveState: true
                },
                cont_fields: {
                    id: {
                        isLocal: true,
                        label: '<div class="icheck-primary">'+
                                    '<input type="checkbox" name="checkAllConts" class="checkAllConts" id="checkAllConts" value="">'+
                                    '<label for="checkAllConts"></label>'+
                                '</div>',
                        render: (data) => {
                            return `<div class="icheck-primary">
                                        <input type="checkbox" name="cont" class="cont" id="cont${data}" value="${data}">
                                        <label for="cont${data}"></label>
                                    </div>`
                        }
                    },
                    name: {label: "Name", sortable: true, searchable: true},
                    email: {label: "Email", sortable: true, searchable: true},
                    address: {label: "Address", sortable: true, searchable: true},
                    phone: {label: "Phone Number", sortable: true, searchable: true},
                    zip_code: {label: "Zip code", sortable: true, searchable: true},
                    created_at: {label: "Date Created", sortable:true, searchable: true},
                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        data: 'id',
                        render: (data) => {
                            return `<button data-action="edit" class="btn btn-info btn-xs"> <i class="fas fa-envelope"></i></button> 
                                <button type="button" data-action="delete" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></button>`
                        }
                    }
                }
            };
        },
        methods: {
            showMessage: function (name='', message='') {
                this.hide_overlay = true;
                this.name = name;
                this.message = message;
                this._modal.modal('show');
            },
            openForm(data, row, tr, target) {
                this.message = data.message;
                this.name = data.name;
                this._modal.modal('show');
                this.hide_overlay = true;
            },
            removeContact(data, row, tr, target) {
                let id = data.id;
                this.swalOptions.text = `You won't be able to revert this.`;
                this.confirmAction (function () {
                    axios.delete('/admin/contact/remove/'+id).then((response) => {
                        console.log(response.data);
                        tr.remove();
                    });
                });
            },
            bulkAction() {
                if (this.b_action) {
                    if (this.rowSelected.length < 1) {
                        this.dialogAlert('Ooops! No contact selected.', '', 'error');
                        return;
                    }

                    let $this = this;

                    if(this.b_action == 'delete') {
                        this.swalOptions.text = `You are about to delete ${this.rowSelected.length} contacts.`;
                        this.confirmAction(function () {
                            axios.delete('/admin/contact/delete/bulk/'+$this.rowSelected)
                            .then((response) => {
                                if (response.data.success == true) {
                                    $this.rowSelected = [];
                                    $this.dialogAlert(response.data.num_deleted_rows+' Contacts Deleted', '', 'success')
                                    $this.$refs.contacts.reload();
                                } else {

                                }
                            }).catch((error) => {
                                console.log(error.response.message);
                            });
                        });
                    }
                } else {
                    this.dialogAlert('Ooops! No action selected.', '', 'error');
                }
            }
        },
        watch: {
            rowSelected(oldData, newData) {}
        },
        mounted() {
            const $this = this;

            this._modal = $('#contactMessageModal');

            this.checkAll('#checkAllConts', '.cont', function (arr) {
                $this.rowSelected = arr;
            });

            this._modal.on('hidden.bs.modal', function () {
                console.log('Modal open')
                this.hide_overlay = false;
                $this.message = '';
                $this.name = '';
            });
        }
    }
</script>