<template>
    <div>
        <form @submit.prevent="updateLegal">

            <div class="col-md-12 border-bottom">
                <div class="card">
                    <div class="card-header">
                        <label for="privacy" class="card-title">Privacy</label>
                    </div>
                    <div class="card-body">
                        <privacy name="privacy" :model="input.privacy" id="privacy" v-on:change="value => {input.privacy = value}"></privacy>
                    </div>
                </div>
            </div>

            <div class="col-md-12 border-bottom">
                
                <div class="card">
                    <div class="card-header">
                        <label for="terms" class="card-title">Terms and Conditions</label>
                    </div>
                    <div class="card-body">
                        <terms name="terms" :model="input.terms_and_conditions" id="terms" v-on:change="value => {input.terms_and_conditions = value}"></terms>
                    </div>
                        
                </div>
            </div>

            <div class="col-12 pt-3 pl-3">
                <button type="submit" class="btn btn-xl btn-success">Update</button>
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
    import summernote from '../plugin/Summernote';
    
    export default {
        mixins: [Url, Plugin, swalUtility],
        props: ['initialLegal'],
        components: {
            privacy: summernote,
            terms: summernote
        },
        data() {
            return {
                site_info: this.initialLegal,
                input: {
                    privacy: '',
                    terms_and_conditions: ''
                }
            };
        },
        methods: {
            updateLegal: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');

                axios.post(this.base_url('site_info/update'), this.input).then((response) => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        this.toast('Legal Updated successfully');
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