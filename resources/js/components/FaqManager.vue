<template>
    <div>
        
        <div class="card-header">
            <h3 class="card-title">FAQs</h3>

            <div class="btn-group float-right" role="group">
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#faqModal"><i class="fas fa-plus-circle"></i> Add FAQ</button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="col-md-12">

                <faq-table 
                    ref="faqs"
                    :fields="faq_fields"
                    :opts="faq_options"
                    @edit="openFaqForm"
                    @delete="removeFaq"></faq-table>

            </div>
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
        <div class="modal fade" id="faqModal">
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
                    <form name="categoryForm" id="categoryForm" @submit.prevent="upsertFaq">
                        <div class="modal-body">
                            <div class="form-group row mb-2 pb-0">
                                <label for="dateDue" class="col-md-3 ml-2 pt-1">Question</label>
                                <div class="col-md-8">
                                    <input type="text" name="question" v-model="input.question" class="form-control" id="question" placeholder="Question">
                                </div>
                            </div>
                            <div class="form-group row mb-0 pb-0 mb-2">
                                <label for="dateDue" class="col-md-3 ml-2 pt-1">Answer</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="answer" v-model="input.answer" placeholder="Answer"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-0 pb-0">
                                <label for="dateDue" class="col-md-3 ml-2 pt-1">Position</label>
                                <div class="col-md-8">
                                    <select name="position" v-model="input.position" class="form-control" id="position">
                                        <option value="">-- Select Position --</option>
                                        <option v-for="pos in positionCount+1" :key="pos" :value="pos">{{ pos }}</option>
                                    </select>
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

    import faqTable from 'vue-datatables-net';
    import 'datatables.net-bs4';
    import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';
    
    export default {
        mixins: [swalUtility, FormUtil],
        components: {faqTable},
        data() {
            return {
                _modal: null,
                rowSelected: [],
                b_action: '',
                modal_title: 'Add FAQ',
                modal_btn_text: 'Add',
                positionCount: 0,
                //determine to show the modal overlay
                hide_overlay: true,

                input: {
                    id: '',
                    question: '',
                    answer: '',
                    position: '',
                    //use in testing title in the server
                    original_question: '',
                },

                faq_options: {
                    ajax: {
                        url: '/admin/faqs',
                        dataSrc: (data) => {
                            this.positionCount = data.length;
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
                faq_fields: {
                    id: {
                        isLocal: true,
                        label: '<div class="icheck-primary">'+
                                    '<input type="checkbox" name="checkAllFaqs" class="checkAllFaqs" id="checkAllFaqs" value="">'+
                                    '<label for="checkAllFaqs"></label>'+
                                '</div>',
                        render: (data) => {
                            return `<div class="icheck-primary">
                                        <input type="checkbox" name="faq" class="faq" id="faq${data}" value="${data}">
                                        <label for="faq${data}"></label>
                                    </div>`
                        }
                    },
                    question: {label: "Question", sortable: true, searchable: true},
                    answer: {label: "Answer", sortable: true, searchable: true},
                    position: {label: "Position", sortable: true, searchable: true},
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

            };
        },
        methods: {
            upsertFaq: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');

                // show overlay
                this.hide_overlay = false;

                axios.post('/admin/faqs/upsert', this.input).then((response) => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        this.hide_overlay = true;
                        this._modal.modal('hide');
                        $('body').removeClass('.modal-open');
                        $('.modal-backdrop').remove();
                        this.$refs.faqs.reload();
                        this.toast(response.data.message);
                    } else {
                        if (response.data.message instanceof Object) {
                            Object.entries(response.data.message).forEach(([index, value]) => {
                                let id = $('#'+index);
                                id.removeClass('is-invald')
                                    .addClass(value.length>0? 'is-invalid':'');
                                id.closest('.form-group').find('.invalid-feedback').remove();

                                id.after('<span class="invalid-feedback">'+value+'</span>');
                            });
                        } else {
                            this.toast(response.data.message, 'erorr');
                        }
                        this.hide_overlay = true;
                    }
                }).catch((error) => {
                    if (error.response) {
                        console.log(error.response.data.message);
                    }
                });
            },
            openFaqForm(data, row, tr, target) {
                let id = data.id;
                console.log(data);
                if (id) {
                    this.input.id = id;
                    this.input.question = data.question;
                    this.input.answer = data.answer;
                    this.input.original_question = data.question;
                    this.input.position = data.position;
                    this.modal_title = 'Update Faq';
                    this.modal_btn_text = 'Update';
                    this._modal.modal('show');
                }
            },
            removeFaq(data, row, tr, target) {
                let id = data.id;
                this.confirmAction (function () {
                    axios.delete('/admin/faq/remove/'+id).then((response) => {
                        console.log(response.data);
                        tr.remove();
                    });
                });
            },
            bulkAction() {
                if (this.b_action) {
                    if (this.rowSelected.length < 1) {
                        this.dialogAlert('Ooops! No Faq selected.', '', 'error');
                        return;
                    }

                    let $this = this;

                    if(this.b_action == 'delete') {
                        this.swalOptions.text = `You are about to delete ${this.rowSelected.length} faqs.`;
                        this.confirmAction(function () {
                            axios.delete('/admin/faqs/delete/bulk/'+$this.rowSelected)
                            .then((response) => {
                                if (response.data.success == true) {
                                    $this.rowSelected = [];
                                    $this.dialogAlert(response.data.num_deleted_rows+' Faqs Deleted', '', 'success')
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
            rowSelected(oldData, newData){}
        },
        mounted() {
            const $this = this;
            this._modal = $('#faqModal');

            this.checkAll('#checkAllFaqs', '.faq', function (arr) {
                $this.rowSelected = arr;
            });

            this._modal.on('hidden.bs.modal', function () {
                console.log('Modal open')
                $this.modal_title = 'Add Faq';
                $this.modal_btn_text = 'Add';
                $this.input.question = '';
                $this.input.answer= '';
                $this.input.position='';
                $this.original_question
                $this.input.id = '';
            });
                
        }
    }
</script>