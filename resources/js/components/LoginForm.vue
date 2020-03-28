<template>
  <div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to Admin Panel</p>

          <form @submit.prevent="login">
            <div class="input-group mb-3">
              <input
                type="email"
                id="email"
                v-model="input.email"
                class="form-control"
                placeholder="Email"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                id="password"
                v-model="input.password"
                class="form-control"
                placeholder="Password"
              />

              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="rememberMe" v-model="input.rememberMe">
                    <label for="rememberMe">Remember Me</label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mb-1">
            <a href="auth/password/request">I forgot my password</a>
          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
  </div>
</template>

<script>
    import axios from 'axios';
    import form from './utilities/Form';
    import url from './utilities/Url';
    import swalUtility from './utilities/swalUtility';

    export default {
        mixins: [form, url, swalUtility],
        data() {
            return {
              input: {
                email: '',
                password: '',
                rememberMe: false}
            }
        },
        methods: {
            login: function () {
                $('.form-group').find('.is-invalid').removeClass('is-invalid');
                axios.post(this.base_url('access/grant'), this.input).then((response) => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        console.log(response.data.message);
                        window.location = this.base_url('backoffice/dashboard');
                        this.resetFormInput(this.input);
                    } else {
                        if (response.data.message instanceof Object) {
                            Object.entries(response.data.message).forEach(([index, value]) => {
                                let id = $('#'+index);
                                id.removeClass('is-invald')
                                    .addClass(value.length>0? 'is-invalid':'');
                                id.closest('.form-group').find('.invalid-feedback').remove();

                                id.parent('.input-group').append('<span class="invalid-feedback">'+value+'</span>');
                            });
                        } else {
                            console.log(response.data.message);
                            this.dialogAlert('Oops!', response.data.message, 'error');
                        }
                    }
                }).catch ((error) => {
                    if (error.response)
                        console.log(error.response.data.message);
                });
            }
        }
    }
</script>