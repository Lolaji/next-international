<template>
    <div>
        <div class="container-fluid">
            <form name="mailForm" @submit.prevent="process">
                
                <div class="row">
                    
                    <div class="col-md-12">
                        
                        <div class="card card-info">

                            <div class="card-header justify-content-between">
                                <h3 class="card-title">Service Details</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <label for="" class="col-md-3 pt-1">Title</label>
                                        <div class="col-md-8">
                                            <input type="text" name="title" v-model="title" id="title" class="form-control" placeholder="Title of the service">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <label for="" class="col-md-3 pt-1">Short Description</label>
                                        <div class="col-md-8">
                                            <textarea name="short_desc" v-model="short_desc" id="short_desc" class="form-control" placeholder="Short description of the service."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <label for="" class="col-md-3 pt-1">Keywords</label>
                                        <div class="col-md-8">
                                            <input type="text" name="keywords" v-model="keywords" id="keywords" class="form-control" placeholder="Keywords with comma seperated e.g. reqruitment, hiring, great service etc">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-info">

                            <div class="card-header justify-content-between">
                                <h3 class="card-title">Icon and Image</h3>
                            </div>

                            <!-- SEO -->
                            <div class="card-body">
                                <div class="col-md-12 pb-3">
                                    <h4>Icon</h4>
                                </div>

                                <div class="col-md-12 mb-5 border-bottom">
                                    <icon-image :options="iconImageOptions" id="icon" ref="iconImage"></icon-image>

                                    <p class="text-danger icon_error"></p>

                                    <div class="col-md-4 mt-2">
                                    
                                        <div class="card-body">
                                            <figure class="figure">
                                                <img :src="base_url('storage/images/service/'+overview_icon)" class="card-img-top" alt="">
                                            </figure>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12 pb-3">
                                        <h4>Header Image</h4>
                                    </div>
                                    
                                    <drop-zone :options="dropzoneOptions" id="dz" ref="dropzone"></drop-zone>

                                    <p class="text-danger header_error"></p>

                                    <div class="col-md-4 mt-2">
                                    
                                        <div class="card-body">
                                            <figure class="figure">
                                                <img :src="base_url('storage/images/service/'+header_image)" class="card-img-top" alt="">
                                            </figure>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-primary card-outline">

                            <div class="card-header">
                                <h3 class="card-title">Service Content</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="form-group">
                                    <summernote name="content" :model="content" v-on:change="value  => {content = value}"></summernote>
                                </div>

                            
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    <a :href="base_url('backoffice/services')" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
                                    <button type="button" id="draft" class="btn btn-dark"><i class="far fa-clock"></i> Draft</button>
                                    <button type="submit" id="save_publish" class="btn btn-primary"><i class="far fa-clock"></i> Save & Publish</button>
                                </div>
                                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
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
    </div>
</template>

<script>
    import Url from './utilities/Url';
    import axios from 'axios';
    import vueDropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';
    import swalUtility from './utilities/swalUtility';
    import summernote from '../plugin/Summernote';

    export default {
        mixins:[Url, swalUtility],
        components: {
            iconImage: vueDropzone,
            dropZone: vueDropzone,
            summernote: summernote
        },
        props: ['serviceData', 'csrfToken'],
        data() {
            return {
                iconImageOptions: {
                    url: this.base_url('upload/service'),
                    thumbnailWidth: 200,
                    maxFilesize: 2,
                    maxFiles: 1,
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    success(file, response) {
                        file.filename = response.filename;
                    },
                    error(file, error, xhr) {
                        $('.icon_error').text(error);
                    },
                    removedfile(file) {
                        $('.icon_error').text('');
                    }
                },
                dropzoneOptions: {
                    url: this.base_url('upload/service'),
                    thumbnailWidth: 200,
                    maxFilesize: 2,
                    maxFiles: 1,
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    success(file, response) {
                        file.filename = response.filename;
                    },
                    error(file, error, xhr) {
                        $('.header_error').text(error);
                    },
                    removedfile(file) {
                        $('.header_error').text('');
                    }
                },
                summernoteOption: {
                    height: 300,
                    placeholder: 'Customize content'
                },
                service: this.serviceData,
                service_id: '',
                title: '',
                header_image: '',
                overview_icon: '',
                short_desc:'',
                keywords: '',
                content: '',
                original_title: ''
            }
        },
        methods: {
            process: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');
                $('.icon_error').text('');
                $('.header_error').text('');

                $('.overlay').removeClass('invisible');

                let files = this.$refs.dropzone.getAcceptedFiles();
                let icon_files = this.$refs.iconImage.getAcceptedFiles();


                if (icon_files.length > 0 && icon_files[0].filename) {
                    this.overview_icon = icon_files[0].filename;
                }

                if (files.length > 0 && files[0].filename) {
                    this.header_image = files[0].filename;
                }

                axios.post(this.base_url('admin/service/upsert'), {
                    id: this.service_id,
                    title: this.title,
                    header_image: this.header_image,
                    overview_icon: this.overview_icon,
                    short_desc: this.short_desc,
                    keywords: this.keywords,
                    content: this.content,
                    original_title: this.original_title
                }).then((response) => {
                    
                    if (response.data.success === true) {
                        this.toast(response.data.message);
                        window.location = this.base_url('backoffice/services');
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
                        // console.log(error.response.data);
                });
            },
            populateForm: function () {
                if (this.service != undefined) {
                    this.service_id = this.service.id;
                    this.title = this.service.title;
                    this.short_desc = this.service.short_desc;
                    this.keywords = this.service.keywords;
                    this.content = this.service.content;
                    this.original_title = this.service.title;
                    this.header_image = this.service.header_image
                    this.overview_icon = this.service.overview_icon
                }
            }
        },
        created() {
            this.populateForm();
        },
        mounted() {
            // $('#content').summernote({
            //     height: 300,
            //     placeholder: 'Customize content...'
            // });
        }
        
    }
</script>