<template>
    <div>
        <div class="contact-us-form">
            <h3 class="title" v-if="is_title == true">{{ title_text }}</h3>
            <form class="comment-form" id="contact_form_submit" @submit.prevent="process">
                <div class="row mb-30-none">
                    <div class="col-sm-6 form-group">
                        <input type="text" placeholder="Name*" class="form-control" v-model="input.name" name="name" id="name">
                    </div>
                    <div class="col-sm-6 form-group">
                        <input type="text" placeholder="Address*" class="form-control" v-model="input.address" name="address" id="address">
                    </div>
                    <div class="col-sm-6 form-group">
                        <input type="text" placeholder="Postal Code*" class="form-control" v-model="input.zip_code" name="zip_code" id="zip_code">
                    </div>
                    <div class="col-sm-6 form-group">
                        <input type="text" placeholder="Phone*" class="form-control" v-model="input.phone" name="phone" id="phone">
                    </div>
                    <div class="col-sm-12 form-group">
                        <input type="text" placeholder="Email*" class="form-control" v-model="input.email" name="email" id="email">
                    </div>
                    <div class="col-sm-12 form-group">
                        <textarea placeholder="Your Message" class="form-control" v-model="input.message" name="message" id="message"></textarea>
                    </div>
                    <div class="col-sm-12 form-group">
                        <button type="submit" :class="buttonClass">Submit Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    import url from './utilities/Url';
    import swalUtility from './utilities/swalUtility';

    export default {
        mixins: [url, swalUtility],
        props: ['formConfig'],
        data() {
            return {
                is_title: false,
                title_text: 'send your message',
                buttonClass: 'default-btn',

                input: {
                    name: '',
                    address: '',
                    zip_code: '',
                    phone: '',
                    email: '',
                    message: ''
                }
            }
        },
        methods: {
            process: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');
                axios.post(this.base_url('contact/send'), this.input).then((response) => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        this.dialogAlert('Message Sent', response.data.message);
                        this.resetForm(this.input);
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
                            this.dialogAlert('Oops! Error Occured!', response.data.message, 'error');
                        }
                    }
                }).catch ((error) => {
                    if (error.response)
                        console.log(error.response.data.message);
                });
            },
            resetForm: function (input) {
                if (input instanceof Object) {
                    Object.entries(input).forEach(([key, value]) => {
                        this.input[key] = '';
                    });
                } else {
                    console.log('Parameter parsed must be an object in resetForm() Method');
                }
            }
        },
        mounted() {
            if (this.formConfig) {
                Object.entries(this.formConfig).forEach(([key, value]) => {
                    this[key] = value;
                });
                
            }

        }
    }
</script>

<style>
    .default-btn {
        cursor: pointer;
        background-color: #182943;
        color: #ffffff;
        font-weight: 700;
        padding-left: 0; }
</style>