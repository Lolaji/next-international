<template>
    <div>
        <table id="tID" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>
                        <div class="icheck-primary">
                            <input type="checkbox" name="checkAll" class="checkAll" id="checkAllTop" value="">
                            <label for="checkAllTop"></label>
                        </div>
                    </th>
                    <th v-for="(th, index) in tableHeader" :key="index">{{ th }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr v-for="data in tableData" :key="data.id">
                    <td>
                        <div class="icheck-primary">
                            <input type="checkbox" name="service" class="service" :id="'serviceid'+data.id" >
                            <label :for="'serviceid'+data.id"></label>
                        </div>
                    </td>
                    <td>{{ data.title }}</td>
                    <td>{{ data.short_desc }}</td>
                    <td>publish</td>
                    <td>{{ data.updated_at }}</td>
                    <td>
                        <a href="" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>
                        <a href="" class="btn btn-info btn-xs" data-target="#updateListModal" data-toggle="modal"> <i class="fas fa-pencil-alt"></i></a>
                        <button type="button" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></button>
                    </td>
                </tr> -->
            </tbody>

            <tfoot v-if="tFooter == true">
                <tr>
                    <th>
                        <div class="icheck-primary">
                            <input type="checkbox" name="checkAll" class="checkAll" id="checkAll-b" value="">
                            <label for="checkAll-b"></label>
                        </div>
                    </th>
                    <th v-for="(th, index) in tableHeader" :key="index">{{ th }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['tHeader','tFooter', 'tData'],
        data(){
            return {
                tableHeader: [],
                tableFooter: false,
                tableData: [],
                datatable: null
            };
        },
        methods: {
            insert: function () {

            }

        },
        mounted() {
            this.tableHeader = this.tHeader;
            this.tableFooter = this.tFooter;
            // this.tableData = this.tData;

            this.$nextTick(function (){
                this.datatable = $('#tID').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "data": this.tData
                });
            });
        }
    }
</script>