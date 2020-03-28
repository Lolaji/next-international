<template>
    <div>
        
        <div class="card-header">
            <h3 class="card-title">Tags</h3>

            <div class="btn-group float-right" role="group" aria-label="...">
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addTag"><i class="fas fa-plus-circle"></i> Add Tag</button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <data-table 
                ref="tags"
                :fields="fields"
                :opts="options"
                @edit="openForm"
                @delete="removeTag"></data-table>
        </div>
        <!-- /.card-body -->
        
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

        <!-- Add Modals -->
        <div class="modal fade" id="addTag">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="overlay d-flex justify-content-center align-items-center" :class="{invisible: hide_overlay}">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <div class="modal-header">
                        <h4 class="modal-title">{{ modal_title }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form name="categoryForm" id="categoryForm" @submit.prevent="upsert">
                        <div class="modal-body">
                            <div class="form-group row mb-2 pb-0">
                                <label for="dateDue" class="col-md-3 ml-2 pt-1">Title</label>
                                <div class="col-md-8">
                                    <input type="text" name="title" v-model="input.title" class="form-control" id="tag-title" placeholder="List title">
                                </div>
                            </div>
                            <div class="form-group row mb-0 pb-0">
                                <label for="dateDue" class="col-md-3 ml-2 pt-1">Description</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="tag-description" v-model="input.description"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">{{ modal_btn_text }}</button>
                        </div>
                    </form>
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

    import dataTable from 'vue-datatables-net';
    import 'datatables.net-bs4';
    import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

    export default {
        mixins: [swalUtility, FormUtil],
        components: {dataTable},
        data() {
            return {
                b_action: '',
                rowSelected: [],
                _modal: null,
                modal_title: 'Add Tag',
                modal_btn_text: 'Add',
                input: {
                    id: '',
                    title: '',
                    description: '',
                    //use in testing title in the server
                    original_title: '',
                },
                //determine to show the modal overlay
                hide_overlay: true,

                options: {
                    ajax: {
                        url: '/admin/tags',
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
                fields: {
                    id: {
                        isLocal: true,
                        label: '<div class="icheck-primary">'+
                                    '<input type="checkbox" name="checkAllTags" class="checkAllTags" id="checkAllTags" value="">'+
                                    '<label for="checkAllTags"></label>'+
                                '</div>',
                        render: (data) => {
                            return `<div class="icheck-primary">
                                        <input type="checkbox" name="tag" class="tag" id="tag${data}" value="${data}">
                                        <label for="tag${data}"></label>
                                    </div>`
                        }
                    },
                    title: {label: "Title", sortable: true, searchable: true},
                    description: {label: "Description", sortable: true, searchable: true},
                    created_at: {label: "Date Created", sortable:true, searchable: true},
                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        data: 'id',
                        render: (data) => {
                            return `<button data-action="edit" class="btn btn-info btn-xs"> <i class="fas fa-pencil-alt"></i></button> 
                                <button type="button" data-action="delete" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></button>`
                        }
                    }
                }
            }
        },
        methods: {
            upsert: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');
                this.hide_overlay = false;

                axios.post('/tag/upsert', this.input)
                .then((response) => {
                    console.log(response.data);
                    if (response.data.success == true) {
                        this._modal.modal('hide');
                        $('body').removeClass('.modal-open');
                        $('.modal-backdrop').remove();
                        this.$refs.tags.reload();
                        this.toast(response.data.message);
                    } else {
                        if (response.data.message instanceof Object) {
                            Object.entries(response.data.message).forEach(([index, value]) => {
                                let id = $('#tag-'+index);

                                id.removeClass('is-invald')
                                    .addClass(value.length>0? 'is-invalid':'');
                                id.closest('.form-group').find('.invalid-feedback').remove();

                                id.after('<span class="invalid-feedback">'+value+'</span>');
                            });
                        } else{
                            this.toast(response.data.message, 'error');
                        }
                    }
                    this.hide_overlay = true;
                }).catch ((error) => {
                    if (error.response) {
                        console.log(error.response.data.message);
                    }
                })
            },
            openForm(data, row, tr, target) {
                let id = data.id;
                if (id) {
                    this.input.id = id;
                    this.input.title = data.title;
                    this.input.description = data.description;
                    this.input.original_title = data.title;
                    this.modal_title = 'Update List';
                    this.modal_btn_text = 'Update';
                    this._modal.modal('show');
                }
            },
            removeTag(data, row, tr, target) {
                let id = data.id;
                this.confirmAction (function () {
                    axios.delete('/tag/remove/'+id).then((response) => {
                        console.log(response.data);
                        tr.remove();
                    });
                });
            },
            bulkAction() {
                if (this.b_action) {
                    if (this.rowSelected.length < 1) {
                        this.dialogAlert('Ooops! No mailing list selected.', '', 'error');
                        return;
                    }

                    let $this = this;

                    if(this.b_action == 'delete') {
                        this.swalOptions.text = `You are about to delete ${this.rowSelected.length} mailing list.`;
                        this.confirmAction(function () {
                            axios.delete('/tag/delete/bulk/'+$this.rowSelected)
                            .then((response) => {
                                if (response.data.success == true) {
                                    $this.rowSelected = [];
                                    $this.dialogAlert(response.data.num_deleted_rows+' Lists Deleted', '', 'success')
                                    $this.$refs.tags.reload();
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
            rowSelected(oldData, nData){}
        },
        mounted() {

            const $this = this;

            this._modal = $('#addTag');

            this.checkAll('#checkAllTags', '.tag', function (arr) {
                $this.rowSelected = arr;
            });

            this._modal.on('hidden.bs.modal', function () {
                console.log('Modal open')
                $this.modal_title = 'Add Mailing List';
                $this.modal_btn_text = 'Add';
                $this.input.title = '';
                $this.input.description= '';
                $this.input.id = '';
            });
        }
    }
</script>