<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Services</h3>
    
                            <div class="btn-group float-right" role="group" aria-label="...">
                                <a href="service/create" class="btn btn-xs btn-primary"><i class="fas fa-plus-circle"></i> Add New Service</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <data-table 
                                ref="serviceTable"
                                :fields="fields"
                                :opts="options"
                                @delete="deleteService"></data-table>

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
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    <!-- /.container-fluid -->
    </div>
</template>

<script>
    import str from './utilities/Str';
    import FormUtil from '../plugin/FormUtil';
    import swalUtility from './utilities/swalUtility';

    import dataTable from 'vue-datatables-net';
    import 'datatables.net-bs4';
    import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

    export default {
        mixins: [str, swalUtility, FormUtil],
        components: {
            dataTable
        },
        data(){
            const vm = this;
            return {
                b_action: '',
                rowSelected: [],
                options: {
                    ajax: {
                        url: '/admin/services',
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
                                    '<input type="checkbox" name="checkAll" class="checkAll" id="checkAll" value="">'+
                                    '<label for="checkAll"></label>'+
                                '</div>',
                        render: (data) => {
                            return `<div class="icheck-primary">
                                        <input type="checkbox" name="service" class="service" id="service${data}" value="${data}">
                                        <label for="service${data}"></label>
                                    </div>`
                        }
                    },
                    title: {label: "Title", sortable: true, searchable: true},
                    short_desc: {label: "Short Description", sortable: true, searchable: true},
                    created_at: {label: "Date Created", sortable:true, searchable: true},
                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        data: {
                            id: 'id',
                            title: 'title'
                        },
                        render: (data) => {
                            return `<a href="/services/${vm.slug(data.title)}" target="__blank" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a> 
                                    <a href="/backoffice/service/update/${data.id}"  class="btn btn-info btn-xs"> <i class="fas fa-pencil-alt"></i></a> 
                                <button type="button" data-action="delete" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></button>`
                        }
                    }
                }
            };
        },
        methods: {
            bulkAction() {
                if (this.b_action) {
                    if (this.rowSelected.length < 1) {
                        this.dialogAlert('Ooops! No services selected.', '', 'error');
                        return;
                    }

                    let $this = this;

                    if(this.b_action == 'delete') {
                        this.swalOptions.text = `You are about to delete ${this.rowSelected.length} Posts.`;
                        this.confirmAction(function () {
                            axios.delete('/admin/service/bulk_delete/'+$this.rowSelected)
                            .then((response) => {
                                console.log(response.data);
                                if (response.data.success == true) {
                                    $this.rowSelected = [];
                                    $this.dialogAlert(response.data.num_deleted_rows+' Posts Deleted', '', 'success')
                                    $this.$refs.leads.reload();
                                } else {
                                    
                                }
                            }).catch((error) => {
                                // console.log(error.response.message);
                            });
                        });
                    }
                } else {
                    this.dialogAlert('Ooops! No action selected.', '', 'error');
                }
            },
            
            deleteService(data, row, tr, target) {
                let id = data.id;
                let $this = this;
                this.swalOptions.text = `You won't be able to revert this.`;
                this.confirmAction (function () {
                    axios.delete('/admin/post/delete/'+id).then((response) => {
                        if (response.data.success == true) {
                            tr.remove();
                            $this.toast(response.data.message);
                        } else {
                            $this.toast(response.data.message);
                        }
                    });
                });
            }
        },
        watch: {
            rowSelected(oldData, nData) {}
        },
        mounted() {
            const $this = this;

            this.checkAll('#checkAll', '.service', function (arr) {
                $this.rowSelected = arr;
            });
        }
    }
</script>
