<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Posts</h3>
    
                            <div class="btn-group float-right" role="group" aria-label="...">
                                <a href="/backoffice/post/create" class="btn btn-xs btn-primary"><i class="fas fa-plus-circle"></i> Create New Post</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- <table id="postTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="icheck-primary">
                                                <input type="checkbox" name="checkAll" class="checkAll" id="checkAllTop" value="">
                                                <label for="checkAllTop"></label>
                                            </div>
                                        </th>
                                        <th>Title</th>
                                        <th>Short Desc.</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(post, index) in posts" :key="post.id" :id="'row'+index">
                                        <td>
                                            <div class="icheck-primary">
                                                <input type="checkbox" name="service" class="service" :id="'serviceid'+post.id" >
                                                <label :for="'serviceid'+post.id"></label>
                                            </div>
                                        </td>
                                        <td>{{ post.title }}</td>
                                        <td>{{ post.short_desc }}</td>
                                        <td>{{ post.status }}</td>
                                        <td>{{ post.created_at }}</td>
                                        <td>
                                            <a :href="base_url('blog/'+slug(post.title))" target="__blank" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>
                                            <a :href="base_url('backoffice/post/update/'+post.id)"  class="btn btn-info btn-xs"> <i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" @click="deletePost(index)" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <div class="icheck-primary">
                                                <input type="checkbox" name="checkAll" class="checkAll" id="checkAll-b" value="">
                                                <label for="checkAll-b"></label>
                                            </div>
                                        </th>
                                        <th>Title</th>
                                        <th>Short Desc.</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table> -->

                            <data-table 
                                ref="postTable"
                                :fields="fields"
                                :opts="options"
                                @delete="deletePost"></data-table>
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
        props: ['initialPosts'],
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
                        url: '/admin/posts',
                        dataSrc: (data) => {
                            console.log(data);
                            return data;
                        }
                    },
                    // data: this.mailingList,
                    dom: "ftr<'row vdtnet-footer'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'pl>>",
                    processing: true,
                    searching: true,
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
                                        <input type="checkbox" name="post" class="post" id="post${data}" value="${data}">
                                        <label for="post${data}"></label>
                                    </div>`
                        }
                    },
                    title: {label: "Title", sortable: true, searchable: true},
                    short_desc: {label: "Short Description", sortable: true, searchable: true},
                    status: {label: "Status", sortable: true, searchable: true},
                    created_at: {label: "Date Created", sortable:true, searchable: true},
                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        data: {
                            id: 'id',
                            title: 'title'
                        },
                        render: (data) => {
                            return `<a href="/blog/${vm.slug(data.title)}" target="__blank" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a> 
                                    <a href="/backoffice/post/update/${data.id}"  class="btn btn-info btn-xs"> <i class="fas fa-pencil-alt"></i></a> 
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
                        this.dialogAlert('Ooops! No post selected.', '', 'error');
                        return;
                    }

                    let $this = this;

                    if(this.b_action == 'delete') {
                        this.swalOptions.text = `You are about to delete ${this.rowSelected.length} Posts.`;
                        this.confirmAction(function () {
                            axios.delete('/admin/post/bulk_delete/'+$this.rowSelected)
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
            
            deletePost(data, row, tr, target) {
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

            this.checkAll('#checkAll', '.post', function (arr) {
                $this.rowSelected = arr;
            });
        },
    }
</script>


