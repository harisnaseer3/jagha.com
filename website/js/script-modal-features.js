(function ($) {

    function getFeatures(selectedValue) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: 'http://127.0.0.1/Property/public/features',
            data: {name: selectedValue},
            dataType: 'json',
            success: function (data) {
                if (data.status === 200) {
                    displayFeatures($.parseJSON(data.data['list']));
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr);
            },
            complete: function (url, options) {

                // $('#featuresModalCenter').on('show.bs.modal', function (event) {
                //     var modal = $(this)
                //     modal.find('.modal-body').append('this is modal from jquery')
                // })
            }
        });
    }

    function getFeaturesForEdit(selectedValue, property_index) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: 'http://127.0.0.1/Property/public/features',
            data: {name: selectedValue, 'index': property_index},
            dataType: 'json',
            success: function (data) {
                let facilities = $.parseJSON(data.data['list']);
                if (data.status === 200 && data.values['features'] === null) {
                    displayFeatures(facilities);
                }
                if (data.status === 200 && data.values['features'] != null) {
                    let features_list = JSON.parse(data.values['features'])['features'];
                    let html = '<input type="hidden" name="features" value="features">' +
                        ' <div class="row">';
                    $.each(facilities, function (index, value) {
                        html +=
                            '   <div class="col-sm-6">' +
                            '       <h6>' + index + '</h6>' +
                            '       <div class="row">';
                        $.each(value, function (idx, val) {
                            html +=
                                '         <div class="col-sm-6">' +
                                '         <label for="' + idx + '">' + idx + '</label>' +
                                '         </div>' +
                                '         <div class="col-sm-6">';
                            if (val.type === 'checkbox') {
                                if (features_list[idx.replace(/ /g, '_')] != null) {
                                    html += '   <input name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '" checked >' +
                                        '     </div>';
                                } else {
                                    html += '   <input name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '" >' +
                                        '     </div>';
                                }
                            } else if (val.type === 'number') {
                                if (features_list[idx.replace(/ /g, '_')] != null) {
                                    html += '    <input name="' + idx + '" type="' + val.type + '" value="' + features_list[idx.replace(/ /g, '_')] + '" id="' + idx + '">' +
                                        '         </div>';
                                } else {
                                    if (features_list[idx.replace(/ /g, '_')] != null) {
                                        html += '    <input name="' + idx + '" type="' + val.type + '" value="' + features_list[idx.replace(/ /g, '_')] + '" id="' + idx + '">' +
                                            '         </div>';
                                    } else {
                                        html += '    <input name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '">' +
                                            '         </div>';
                                    }

                                }
                            } else if (val.type === 'select') {
                                html += '    <select name="' + idx + '" type="' + val.type + '" id="' + idx + '">';
                                let options = '';
                                options += '<option value=""  selected disabled>Choose here</option>';
                                $.each(val.options, function (index1, value1) {
                                    if (features_list[idx.replace(/ /g, '_')] != null && features_list[idx.replace(/ /g, '_')] === value1) {
                                        options += '<option value="' + value1 + '">' + value1 + '</option>';
                                    } else
                                        options += '<option value="' + value1 + '">' + value1 + '</option>';
                                });
                                html += options;
                                html += '</select>' +
                                    '    </div>';
                            } else {
                                if (features_list[idx.replace(/ /g, '_')] != null) {
                                    html += '    <input name="' + idx + '" type="' + val.type + '" value="' + features_list[idx.replace(/ /g, '_')] + '" id="' + idx + '">' +
                                        '         </div>';
                                } else {
                                    html += '    <input name="' + idx + '" type="' + val.type + '" value="" id="' + idx + '">' +
                                        '         </div>';
                                }
                            }
                            html += '        <input type="hidden"  name="' + idx + '-icon" value="' + val.icon + '">';
                        });
                        html += '        </div>' +
                            '   </div>';
                    });
                    html += '</div>' +
                        '<a href="javascript:void(0)" type="button" class="btn d-block" style="background-color: #274abb; margin-top: 10px; color: white"' +
                        ' data-dismiss="modal" id="area-unit-save">SAVE</a>';

                    $('#features-model').html(html);
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                // console.log(status);
                // console.log(xhr);
            },
            complete: function (url, options) {
            }
        });
    }

    function displayFeatures(facilities) {
        let html = '<input type="hidden" name="features" value="features">' +
            ' <div class="row">';
        $.each(facilities, function (index, value) {
            html +=
                '   <div class="col-sm-6">' +
                '       <h6>' + index + '</h6>' +
                '       <div class="row">';
            $.each(value, function (idx, val) {
                html +=
                    '         <div class="col-sm-6">' +
                    '         <label for="' + idx + '">' + idx + '</label>' +
                    '         </div>' +
                    '         <div class="col-sm-6">';
                if (val.type === 'checkbox') {
                    html += ' <input name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '">' +
                        ' </div>';
                } else if (val.type === 'number') {
                    html += '    <input name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '">' +
                        '         </div>';
                } else if (val.type === 'select') {
                    html += '    <select name="' + idx + '" type="' + val.type + '" id="' + idx + '">';
                    let options = '';
                    options += '<option value=""  selected disabled>Choose here</option>';
                    $.each(val.options, function (index1, value1) {
                        options += '<option value="' + value1 + '">' + value1 + '</option>';
                    });
                    html += options;
                    html += '</select>' +
                        '    </div>';
                } else {
                    html += '    <input name="' + idx + '" type="' + val.type + '" value="" id="' + idx + '">' +
                        '         </div>';
                }
                html += '        <input type="hidden"  name="' + idx + '-icon" value="' + val.icon + '">';
            });
            html += '        </div>' +
                '   </div>';

        });
        html += '</div>' +
            '<a href="javascript:void(0)" type="button" class="btn d-block" style="background-color: #274abb; margin-top: 10px; color: white"' +
            ' data-dismiss="modal" id="area-unit-save">SAVE</a>';

        $('#features-model').html(html);
    }

    function displayFeatureBtn() {
        let show_features_bedroom_inputs = ['House', 'Flat', 'Upper Portion', 'Lower Portion', 'Farm House', 'Office', 'Shop', 'Warehouse', 'Factory', 'Building', 'Other']
        let subtype = $('[name^=property_subtype-]:checked').val();
        if (jQuery.inArray(subtype, show_features_bedroom_inputs) !== -1) {
            //    if subtype exists in array
            $('.selection-hide').show();
            $('.btn-hide').show();
        } else if (subtype === 'Penthouse' || subtype === 'Room') {
            $('.selection-hide').show();
            $('.btn-hide').hide();
        } else if (subtype === 'Residential Plot' || subtype === 'Commercial Plot' || subtype === 'Agricultural Land') {
            $('.selection-hide').hide();
            $('.btn-hide').show();
        } else {
            $('.selection-hide').hide();
            $('.btn-hide').hide();
        }
    }

    $(document).ready(function () {
        let selectValue = '';
        $('[name^=property_subtype-]').on('click', function (e) {
            selectValue = $('[name^=property_subtype-]:checked').val();
            if (selectValue !== 'Penthouse' && selectValue !== 'Room')
                getFeatures(selectValue);
            displayFeatureBtn();

        });
        displayFeatureBtn();
        // to get data for features in edit view
        if ($('[name^=property_subtype-]:checked').length > 0) {
            selectValue = $('[name^=property_subtype-]:checked').val();
            let property_index = $('[name=data-index]').val();
            if (selectValue !== 'Penthouse' && selectValue !== 'Room')
                getFeaturesForEdit(selectValue, property_index);
            displayFeatureBtn();
        }

    });
})
(jQuery);
