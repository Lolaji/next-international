<template>
    
        <select :name="name" class="select2" :id="name" :data-placeholder="placeholder" style="width: 100%;">
            <!-- <option v-for="(data, index) in dataOption" :key="index" :value="data.value">{{ data.text }}</option> -->
            <!-- <option value="Recruitment">Recruitment</option>
            <option value="Model">Model</option> -->
        </select>
    
</template>

<script>
    import '../../../public/assets/plugin/select2/css/select2.min.css';
    import '../../../public/assets/plugin/select2-bootstrap4-theme/select2-bootstrap4.min.css'
    import '../../../public/assets/plugin/select2/js/select2.full';

    export default {
        model: {
            prop: 'model',
            event: 'change'
        },
        props: {
            name: {
                type: String,
                required: true
            },
            model: {
                required: true
            },
            placeholder: {
                type: String,
                default: 'Select Option'
            },
            dataOption: {
                type: Object,
                required: true,
                default(){
                    return {}
                },
            },
            settings: {
                type: Object,
                default() {
                    return {
                        theme: 'bootstrap4'
                    }
                }
            },
            multiple: {
                type: Boolean,
                default: false
            }
        },
        created(){
            
        },
        mounted(){
            let vm = this;
            let value = "";

            if (this.multiple == true) {
                $(this.$el).attr('multiple', 'multiple');
            }

            $(this.$el).select2(this.settings);
            
            let selectedData = $(this.$el).select2('data');

            // if (selectedData != undefined) {
                console.log(selectedData)
            // }

            $(this.$el).on('change', function () {
                var data = $(this).select2('data');
                    
                for(var i=0; i<data.length;i++) {
                    value+= data[i].text+";";
                }
                console.log(value.replace(/;\s*$/, ''));
                // vm.model = value.replace(/;\s*$/, '')
                vm.$emit('change', value.replace(/;\s*$/, ''));
            });
        }
        
    }
</script>