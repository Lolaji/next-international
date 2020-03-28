<template>

        <div class="container-fluid">
            <form name="postForm" @submit.prevent="process">
                <div class="row">

                    <div class="col-md-3">

                        <div class="card card-info">
                                <div class="card-header justify-content-between">
                                    <h3 class="card-title">Post Details</h3>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" v-model="post.category" id="category" class="form-control" style="width: 100%;">
                                            <option value="">-- Select category --</option>
                                            <option v-for="cat in categories" :key="cat.id" :value="cat.title">{{cat.title}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Tags</label>

                                        <select-two 
                                            name="'tags'" 
                                            v-model="post.tags" 
                                            :options="selectOpt" 
                                            :settings="settings"
                                            @select="tagSelected($event)"></select-two>

                                    </div>

                                    <div class="form-group clearfix border-bottom pb-3 pt-3">
                                        <label>Visibility</label>
                                        <div class="icheck-primary ">
                                            <input type="radio" name="status" v-model="post.status" class="status" id="draft" value="draft">
                                            <label for="draft">Draft</label>
                                        </div>
                                        <div class="icheck-primary">
                                            <input type="radio" name="status" v-model="post.status" class="status" id="publish" checked value="publish">
                                            <label for="publish">Publish</label>
                                        </div>
                                        <div class="icheck-primary">
                                            <input type="radio" name="status" v-model="post.status" class="status" id="unpublish" checked value="unpublish">
                                            <label for="unpublish">Unpublish</label>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div>
                    
                    <div class="col-md-9">

                        <div class="card card-info">
                            <div class="card-header justify-content-between">
                                <h3 class="card-title">Post Details</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <label for="" class="col-md-3 pt-1">Title</label>
                                        <div class="col-md-8">
                                            <input type="text" name="title" v-model="post.title" id="title" class="form-control" placeholder="Title of the service">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <label for="" class="col-md-3 pt-1">Short Description</label>
                                        <div class="col-md-8">
                                            <textarea name="short_desc" v-model="post.short_desc" id="short_desc" class="form-control" placeholder="Short description of the service."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="row">
                                        <label for="" class="col-md-3 pt-1">Keywords</label>
                                        <div class="col-md-8">
                                            <input type="text" name="keywords" v-model="post.keywords" id="keywords" class="form-control" placeholder="Keywords with comma seperated e.g. reqruitment, hiring, great service etc">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-info">
                            <div class="card-header justify-content-between">
                                <h3 class="card-title">Header Image</h3>
                            </div>

                            <!-- Header image upload form  -->
                            <div class="card-body">

                                <drop-zone :options="optionDropzone" id="dz" ref="dropzone"></drop-zone>

                                <div class="col-md-4 mt-2">
                                
                                    <div class="card-body">
                                        <figure class="figure">
                                            <img :src="base_url('storage/images/post/'+post.header_image)" class="card-img-top" alt="">
                                        </figure>
                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Content</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="form-group">
                                    <summernote name="content" :model="post.content" v-on:change="value => {post.content = value}"></summernote>
                                </div>

                            
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    <a :href="base_url('backoffice/posts')" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancel</a>
                                    <button type="button" class="btn btn-dark" @click.prevent="savePreview"><i class="far fa-eye"></i> Preview</button>
                                    <button type="submit" id="sendEmailBtn" class="btn btn-primary"><i class="far fa-save"></i> Save & Publish</button>
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

</template>

<script>
    import axios from 'axios';
    import Url from './utilities/Url';
    import vueDropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import swalUtility from './utilities/swalUtility';
    import summernote from '../plugin/Summernote';
    import '../../../public/assets/plugin/select2/css/select2.min.css';
    import '../../../public/assets/plugin/select2-bootstrap4-theme/select2-bootstrap4.min.css';
    import Select2 from 'v-select2-component';

    export default {
        mixins: [Url, swalUtility],
        props: ['initialCategories', 'postData', 'csrfToken', 'initialTags'],
        components: {
            dropZone: vueDropzone,
            summernote: summernote,
            selectTwo: Select2
        },
        data() {
            return {
                optionDropzone: {
                    url: this.base_url('upload/post'),
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
                        $('.upload_error').text(error);
                    },
                    removedfile(file) {
                        $('.upload_error').text('');
                    }
                },
                post: {
                    tags:"",
                    id: '',
                    category:"",
                    content:"",
                    status: "draft",
                    header_image: '',
                    keywords:"",
                    short_desc:"",
                    title:"",
                    original_title: '',
                },
                preview: false,
                categories: this.initialCategories,
                selectOpt: [],
                settings: {
                    theme: "bootstrap4",
                    placeholder: 'Select Tags',
                    multiple: true,
                }
            };
        },
        methods: {
            process: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');
                $('.upload_error').text('');

                let files = this.$refs.dropzone.getAcceptedFiles();

                if (files.length > 0 && files[0].filename) {
                    this.post.header_image = files[0].filename;
                }
                axios.post(this.base_url('admin/post/upsert/'), this.post)
                .then((response) => {
                    console.log(response.data)
                    if (response.data.success === true) {
                        this.toast(response.data.message);
                        if(this.preview) {
                            this.preview = false;
                            window.open('http://localhost:8000/blog/'+response.data.post_title, '_blank');
                        } else {
                            window.location = this.base_url('backoffice/posts');
                        }
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
            },
            savePreview: function () {
                this.post.status = 'draft';
                this.preview = true;
                this.process();

            },
            tagSelected ({id, text, selected}) {
                console.log({id, text, selected})
            }
        },
        created() {

            if (this.initialTags != "null") {
                for(var i=0; i<this.initialTags.length; i++) {
                    this.selectOpt[i] = {
                        id: this.initialTags[i].title,
                        text: this.initialTags[i].title
                    }
                }
            }

            if (this.postData != undefined) {
                this.post = this.postData;
                const tagArr = this.postData.tags.split(';');
                this.post.tags = tagArr;
                this.post.original_title = this.postData.title;
            }

            // if (this.postData != undefined) {
            //     let tagArr = this.postData.tags;
            //     console.log(tagArr);
            // }
        }

    }
</script>