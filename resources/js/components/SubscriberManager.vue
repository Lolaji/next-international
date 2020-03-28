<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Subscribers</h3>
            </div>
            <div class="card-body">

                <subscriber-table 
                    ref="subscribers"
                    :fields="subs_fields"
                    :opts="subs_options"                    
                    @delete="removeSubscriber"></subscriber-table>
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
    </div>
</template>

<script>

    import axios from 'axios';
    import 'bootstrap';
    import swalUtility from './utilities/swalUtility';
    import FormUtil from '../plugin/FormUtil';

    import subscriberTable from 'vue-datatables-net';
    import 'datatables.net-bs4';
    import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

    export default {
        mixins: [swalUtility, FormUtil],
        components: {subscriberTable},
        data() {
            return {
                rowSelected: [],
                b_action: '',
                subs_options: {
                    ajax: {
                        url: '/admin/subscribes',
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

                subs_fields: {
                    id: {
                        isLocal: true,
                        label: '<div class="icheck-primary">'+
                                    '<input type="checkbox" name="checkAllSubs" class="checkAllSubs" id="checkAllSubs" value="">'+
                                    '<label for="checkAllSubs"></label>'+
                                '</div>',
                        render: (data) => {
                            return `<div class="icheck-primary">
                                        <input type="checkbox" name="sub" class="sub" id="sub${data}" value="${data}">
                                        <label for="sub${data}"></label>
                                    </div>`
                        }
                    },
                    firstname: {label: "First Name", sortable: true, searchable: true},
                    lastname: {label: "Last Name", sortable: true, searchable: true},
                    email: {label: "Email", sortable: true, searchable: true},
                    created_at: {label: "Date Created", sortable:true, searchable: true},
                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        data: 'id',
                        render: (data) => {
                            return `<button type="button" data-action="delete" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></button>`
                        }
                    }
                }
            };
        },
        methods: {

            removeSubscriber(data, row, tr, target) {
                let id = data.id;
                this.swalOptions.text = `You won't be able to revert this.`;
                this.confirmAction (function () {
                    axios.delete('/admin/subscriber/remove/'+id).then((response) => {
                        console.log(response.data);
                        tr.remove();
                    });
                });
            },
            bulkAction() {
                if (this.b_action) {
                    if (this.rowSelected.length < 1) {
                        this.dialogAlert('Ooops! No subscriber selected.', '', 'error');
                        return;
                    }

                    let $this = this;

                    if(this.b_action == 'delete') {
                        this.swalOptions.text = `You are about to delete ${this.rowSelected.length} subscribers.`;
                        this.confirmAction(function () {
                            axios.delete('/admin/subscriber/delete/bulk/'+$this.rowSelected)
                            .then((response) => {
                                if (response.data.success == true) {
                                    $this.rowSelected = [];
                                    $this.dialogAlert(response.data.num_deleted_rows+' Subscribers Deleted', '', 'success')
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

            this.checkAll('#checkAllSubs', '.sub', function (arr) {
                $this.rowSelected = arr;
            });
        }
    }
</script>