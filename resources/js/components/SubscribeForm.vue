<template>
    <div>
        
            <form class="faq-form" @submit.prevent="processSubscription">
                <div class="row mb-30-none">

                    <div class="col-sm-6 form-group">
                        <input type="text" v-model="input.firstName" class="form-control mb-0" id="firstName" placeholder="First Name">
                    </div>
                    <div class="col-sm-6 form-group">
                        <input type="text" v-model="input.lastName" id="lastName" class="form-control mb-0" placeholder="Last Name">
                    </div>
                    
                    <div class="col-sm-12 form-group">
                        <input type="text" v-model="input.email" id="email" class="form-control mb-0" placeholder="Email Adress">
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="generic-green-btn">SUBSCRIBE</button>
                    </div>
                </div>
            </form>
        
    </div>
</template>

<script>

    import axios from 'axios';
    import url from './utilities/Url';
    import swalUtility from './utilities/swalUtility';

    export default {
        mixins: [url, swalUtility],
        data() {
            return {
                input: {
                    firstName: '',
                    lastName: '',
                    email: ''
                }
            };
        },
        methods: {
            processSubscription: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');
                axios.post(this.base_url('subscriber/create'), this.input)
                .then((response) => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        this.dialogAlert('Subscription Successful', '');
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
                            this.dialogAlert('Oops! Error Occured!', response.data.message, 'error')
                        }
                    }
                }).catch((error) => {
                    if (error.response)
                        console.log(error.response.data.message);
                })
            },
            resetForm: function (input) {
                Object.entries(input).forEach(([key, value]) => {
                    this.input[key] = '';
                });
            }
        }
    }
</script>