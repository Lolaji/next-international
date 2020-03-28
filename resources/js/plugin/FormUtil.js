export default {
    methods : {
        /**
         * CheckAll 
         * 
         * @param mainCheckBoxAttr DOM attribute of the checkbox that will check bunch of checkboxes
         * @param checkBoxesAttr   DOM attribute of bunch of checkboxes that will be check
         * @param callback()       Callback method that return the latest array of checked checkboxes value
         */
        checkAll(mainCheckBoxAttr, checkBoxesAttr, callback=null) {
            const $this = this;

            let selecedArr = [];

            /**
             * Main checkbox that check bunch of checkboxes and
             * return the latest array of checkboxs value through callback()
             * 
             *  return @array
             */
            $(document).on('change', mainCheckBoxAttr, function (e) {
                $(checkBoxesAttr).each(function (index, value) {
                    $(value).prop('checked', e.target.checked);
                    if ($(value).is(':checked')) {
                        if (selecedArr.includes($(value).val()) == false)
                            selecedArr.push($(value).val());
                    } else {
                        if (selecedArr.length > 0){
                            var f = selecedArr.filter(function (index) {
                                return $(value).val() != index;
                            });
                            selecedArr = f;
                        }
                    }
                });
                callback(selecedArr);
            });

            /**
             * Bunch of checkboxes to be check using the main checkbox and
             * also checked itself and return the latest array of checked checkboxes
             * value through the callback() method
             * 
             * return @array
             */
            $(document).on('change', checkBoxesAttr, function (e) {
                if (e.target.checked) {
                    selecedArr.push(e.target.value);

                    if (selecedArr.length == $(checkBoxesAttr).length) {
                        $(mainCheckBoxAttr).prop("checked", true);
                    }
                } else {
                    var filter = selecedArr.filter(function (index, number, array) {
                        return e.target.value != index;
                    });
                    selecedArr = filter;

                    if (selecedArr.length < $(checkBoxesAttr).length) {
                        if ($(mainCheckBoxAttr).is(":checked"))
                            $(mainCheckBoxAttr).prop("checked", false);
                    }
                }
                callback(selecedArr);
            });
        },
        resetFormInput(input) {
            if (input instanceof Object) {
                Object.entries(input).forEach(([key, value]) => {
                    this.input[key] = '';
                });
            } else {
                console.log('Parameter parsed must be an object in resetForm() Method');
            }
        },
        showError(errorObj) {
            Object.entries(errorObj).forEach(([index, value]) => {
                let id = $('#'+index);
                id.removeClass('is-invald')
                    .addClass(value.length>0? 'is-invalid':'');
                    id.closest('.form-group').find('.invalid-feedback').remove();

                id.after('<span class="invalid-feedback">'+value+'</span>');
            });
        }
    }
}