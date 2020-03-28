<template>
    <div>
        <form @submit.prevent="updateSiteInfo">

            <div class="col-md-12 border-bottom">
                <div class="form-group col-12">
                    <div class="row">
                        <label for="site_short_description" class="col-md-3">Site Short Description</label>
                        <div class="col-md-6">
                            <textarea name="site_short_description" v-model="input.site_short_description" id="site_short_description" class="form-control" placeholder="" ></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border-bottom pt-4">
                <div class="form-group col-12">
                    <div class="row">
                        <label for="location" class="col-md-3">Location</label>
                        <div class="col-md-6">
                            <input type="text" name="location" v-model="input.location" id="location" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="row">
                        <label for="phone" class="col-md-3">Phone Number</label>
                        <div class="col-md-6">
                            <input type="text" name="phone" v-model="input.phone" id="phone" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="row">
                        <label for="contact_email_address" class="col-md-3">Contact Email Address</label>
                        <div class="col-md-6">
                            <input type="text" name="contact_email_address" v-model="input.contact_email_address" id="contact_email_address" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border-bottom pt-4">
                <div class="form-group col-12">
                    <div class="row">
                        <label for="facebook" class="col-md-3">Facebook</label>
                        <div class="col-md-6">
                            <input type="text" name="facebook" v-model="input.facebook" id="facebook" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="row">
                        <label for="linkedin" class="col-md-3">LinkedIn</label>
                        <div class="col-md-6">
                            <input type="text" name="linkedin" v-model="input.linkedin" id="linkedin" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="row">
                        <label for="twitter" class="col-md-3">Twitter</label>
                        <div class="col-md-6">
                            <input type="text" name="twitter" v-model="input.twitter" id="twitter" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-12 pt-3">
                <div class="row">
                    <label for="phone" class="col-md-3">&nbsp; &nbsp;</label>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</template>

<script>

    import axios from 'axios';
    import Url from './utilities/Url';
    import Plugin from './utilities/Plugin';
    import 'bootstrap';
    import swalUtility from './utilities/swalUtility';
    
    export default {
        mixins: [Url, Plugin, swalUtility],
        props: ['initialSiteInfo'],
        data() {
            return {
                site_info: this.initialSiteInfo,
                input: {
                    location: '',
                    contact_email_address: '',
                    phone: '',
                    site_short_description: '',
                    facebook: '',
                    linkedin: '',
                    twitter: ''
                }
            };
        },
        methods: {
            updateSiteInfo: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');

                axios.post('/site_info/update', this.input).then((response) => {
                    console.log(response.data);
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
                    if (error.response) {
                        console.log(error.response.data.message);
                    }
                });
            }
        },
        created(){
            for (var i=0; i < this.site_info.length; i++) {
                this.input[this.site_info[i].name] = this.site_info[i].content;
            }
        }
    }
</script>