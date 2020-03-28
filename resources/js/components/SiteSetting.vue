<template>
    <div>

        <div class="col-md-12 border-bottom">
            <div class="form-group col-12">
                <div class="row">
                    <label for="site_short_description" class="col-md-3">Maintenance Mode</label>
                    <div class="col-md-3">
                        <select name="maintenance" v-model="maintenance" :disabled="disabled" @change="changeMaintenanceMode" id="maintenance" class="form-control">
                            <option value="1">Activate</option>
                            <option value="0">De-activate</option>
                        </select>
                    </div>
                    <div class="col-md-3 pt-1" v-if="loading == true">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">{{ (maintenance == 1)? 'Activating': 'De-Activating' }}...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';
    import 'bootstrap';
    import swalUtility from './utilities/swalUtility';

    export default {
        mixins: [swalUtility],
        props: ['maintenanceMode'],
        data(){
            return {
                maintenance: '',
                disabled: false,
                loading: false
            }
        },
        methods: {
            changeMaintenanceMode() {
                this.disabled = true;
                this.loading = true;
                axios.post('/maintenance/change', {value: this.maintenance}).then((response) => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        this.disabled = false;
                        this.loading = false;
                        this.toast(response.data.message);
                    } else {
                        this.toast(response.data.message, 'error');
                    }
                }).catch((error) => {
                        // console.log(error.response.data);
                });
            
            }
        },
        mounted(){
            if (this.maintenanceMode != null) {
                this.maintenance = this.maintenanceMode;
            }
        }
    }
</script>