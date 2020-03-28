<template>

        <div class="container-fluid">
            <form name="postForm" @submit.prevent="process">
                <div class="row">
                    
                    <div class="col-md-12">

                        <div class="card card-info">
                            <div class="card-header justify-content-between">
                                <h3 class="card-title">Profile Image</h3>
                            </div>

                            <!-- Header image upload form  -->
                            <div class="card-body">

                                <drop-zone :options="optionDropzone" id="dz" ref="dropzone"></drop-zone>

                                <p class="text-danger upload_error"></p>

                                <div class="col-md-4 mt-2">
                                
                                    <div class="card-body" v-if="user.image != null">
                                        <figure class="figure">
                                            <img :src="base_url('storage/images/profile/'+user.image)" class="card-img-top" alt="">
                                        </figure>
                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- /.card -->

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Profile Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <label for="" class="col-md-3 pt-1">Username</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="username" v-model="user.username" id="username" class="form-control" placeholder="username">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <label for="" class="col-md-3 pt-1">Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="name" v-model="user.name" id="name" class="form-control" placeholder="Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <label for="" class="col-md-3 pt-1">Email Address</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="email" v-model="user.email" id="email" class="form-control" placeholder="Email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="row">
                                                <label for="" class="col-md-3 pt-1">Bio</label>
                                                <div class="col-md-8">
                                                    <textarea name="bio" v-model="user.bio" id="bio" class="form-control" cols="20" placeholder="Bio..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    <button type="submit" id="updateBtn" class="btn btn-primary"> Update</button>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    
                </div>
                <!-- /.row -->
            </form>
        </div>
        <!-- /.container-fluid -->

</template>

<script>
    import axios from 'axios';
    import Url from './utilities/Url';
    import vueDropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import swalUtility from './utilities/swalUtility';    

    export default {
        mixins: [Url, swalUtility],
        props: ['userData', 'csrfToken'],
        components: {
            dropZone: vueDropzone,
        },
        data() {
            return {
                optionDropzone: {
                    url: this.base_url('upload/profile'),
                    thumbnailWidth: 200,
                    maxFilesize: 2,
                    maxFiles: 1,
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    removedfile(file) {
                        console.log(file);
                        file.previewElement.remove();
                        $('.upload_error').text('');
                    },
                    success(file, response) {
                        file.filename = response.filename;
                    },
                    error(file, error, xhr) {
                        console.log(error);
                        $('.upload_error').text(error);
                    }
                },
                user: {
                    username: '',
                    name: '',
                    email: '',
                    bio: '',
                    image: ''
                }
            };
        },
        methods: {
            process: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');
                $('.upload_error').text('');
                let files = this.$refs.dropzone.getAcceptedFiles();

                if (files.length > 0 && files[0].filename) {
                    this.user.image = files[0].filename;
                }
                axios.post(this.base_url('admin/profile/update'), this.user)
                .then((response) => {
                    console.log(response.data)
                    if (response.data.success === true) {
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
                            this.toast(response.data.message, 'error');
                        }
                    }
                }).catch((error) => {
                    console.log(error.response.data.message);
                });
            }
        },
        created() {
            if (this.userData != undefined) {
                Object.entries(this.user).forEach(([key, value]) => {
                    // console.log(key)
                    this.user[key] = this.userData[key]
                });
            }
        }

    }
</script>

<style>
    .upload_error {
        margin-top: 10px;
    }
</style>