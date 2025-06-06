(function ($) {

    function getFeatures(selectedValue) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: window.location.origin + '/features',
            data: {name: selectedValue},
            dataType: 'json',
            success: function (data) {
                if (data.status === 200) {
                    displayFeatures($.parseJSON(data.data['list']));
                }
            },
            error: function (xhr, status, error) {
            },
            complete: function (url, options) {
                //read error tag value to dispaly it on error return
                if ($('input[name="features-error"]').val() !== '') {
                    getDataOnError();
                }
            }
        });
    }

    function getDataOnError() {
        let tags = $('.feature-tag-badge');
        if (!tags.length > 0) {
            // $('input[name="features-error"]').val()
            $('.feature-alert').remove();
            $('.feature-tags').append($('input[name="features-error"]').val());
        }

        tags.each(function (i, obj) {
            let div = $(this).find('a');
            let id = div.attr('data-id');
            let type = div.attr('data-type');
            let value = div.attr('data-value');
            if (type === 'checkbox') {
                $('input[id="' + id + '"]').prop('checked', true);
            } else if (type === 'select-one') {
                $('select[id="' + id + '"] option[value="' + value + '"]').attr("selected", "selected");
            } else {
                $('input[id="' + id + '"]').val(value);
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
            url: window.location.origin + '/features',
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
                                    html += '   <input class="selected-feature" name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '" checked >' +
                                        '     </div>';
                                } else {
                                    html += '   <input  class="selected-feature"  name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '" >' +
                                        '     </div>';
                                }
                            } else if (val.type === 'number') {
                                if (features_list[idx.replace(/ /g, '_')] != null) {
                                    html += '    <input class="selected-feature" name="' + idx + '" type="' + val.type + '" value="' + features_list[idx.replace(/ /g, '_')] + '" id="' + idx + '" min="0">' +
                                        '         </div>';
                                } else {
                                    if (features_list[idx.replace(/ /g, '_')] != null) {
                                        html += '    <input class="selected-feature" name="' + idx + '" type="' + val.type + '" value="' + features_list[idx.replace(/ /g, '_')] + '" id="' + idx + '" min="0">' +
                                            '         </div>';
                                    } else {
                                        html += '    <input  class="selected-feature" name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '" min="0">' +
                                            '         </div>';
                                    }

                                }
                            } else if (val.type === 'select') {
                                html += '    <select class="selected-feature" name="' + idx + '" type="' + val.type + '" id="' + idx + '">';
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
                                if (features_list[idx.replace(/ /g, '_')] !== null) {
                                    html += '    <input class="selected-feature" name="' + idx + '" type="' + val.type + '" value="' + features_list[idx.replace(/ /g, '_')] + '" id="' + idx + '">' +
                                        '         </div>';
                                } else {
                                    html += '    <input  class="selected-feature" name="' + idx + '" type="' + val.type + '" value="" id="' + idx + '">' +
                                        '         </div>';
                                }
                            }
                            html += '        <input type="hidden"  name="' + idx + '-icon" value="' + val.icon + '">';
                        });
                        html += '        </div>' +
                            '   </div>';
                    });
                    html += '</div>' +
                        '<div class="row"><div class="col-sm-6">' +
                        '<a href="javascript:void(0)" type="button" class="btn d-block" style="background-color: #274abb; margin-top: 10px; color: white"' +
                        ' data-dismiss="modal" id="area-unit-save">Save</a>'
                        + '</div><div class="col-sm-6">' +
                        '<a href="javascript:void(0)" type="button" class="btn d-block" style="background-color: #dc3545;; margin-top: 10px; color: white"' +
                        ' data-dismiss="modal" id="area-unit-save">Cancel</a>' + '</div></div>';

                    $('#features-model').html(html);
                    $('.read-features').show();
                    $.each($('.selected-feature'), function (index, value) {
                        displayFeatureTag(value);
                    });
                }
            },
            error: function (xhr, status, error) {
            },
            complete: function (url, options) {
                if ($('input[name="features-error"]').val() !== '') {
                    getDataOnError();
                }
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
                    html += ' <input class="selected-feature" name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '">' +
                        ' </div>';
                } else if (val.type === 'number') {
                    html += '    <input class="selected-feature" name="' + idx + '" type="' + val.type + '" value="0" id="' + idx + '" min="0">' +
                        '         </div>';
                } else if (val.type === 'select') {
                    html += '    <select class="selected-feature" name="' + idx + '" type="' + val.type + '" id="' + idx + '">';
                    let options = '';
                    options += '<option value=""  selected disabled>Choose here</option>';
                    $.each(val.options, function (index1, value1) {
                        options += '<option value="' + value1 + '">' + value1 + '</option>';
                    });
                    html += options;
                    html += '</select>' +
                        '    </div>';
                } else {
                    html += '    <input class="selected-feature" name="' + idx + '" type="' + val.type + '" value="" id="' + idx + '">' +
                        '         </div>';
                }
                html += '        <input type="hidden"  name="' + idx + '-icon" value="' + val.icon + '">';
            });
            html += '        </div>' +
                '   </div>';

        });
        html += '</div>' +
            '<div class="row"><div class="col-sm-6">' +
            '<a href="javascript:void(0)" type="button" class="btn d-block" style="background-color: #274abb; margin-top: 10px; color: white"' +
            ' data-dismiss="modal" id="area-unit-save">Save</a>'
            + '</div><div class="col-sm-6">' +
            '<a href="javascript:void(0)" type="button" class="btn d-block" style="background-color: #dc3545; margin-top: 10px; color: white"' +
            ' data-dismiss="modal" id="area-unit-save">Cancel</a>' + '</div></div>';

        $('#features-model').html(html);
    }

    function displayFeatureBtn() {
        let show_features_bedroom_inputs = ['House', 'Flat', 'Upper Portion', 'Lower Portion', 'Farm House', 'Office', 'Shop', 'Warehouse', 'Factory', 'Building', 'Other']
        let subtype = $('[name^=property_subtype-]:checked').val();
        if (jQuery.inArray(subtype, show_features_bedroom_inputs) !== -1) {
            //    if subtype exists in array
            $('.selection-hide').show();
            $('.btn-hide').show();
            if ($('.feature-tag-badge').length == 0)
                $('.feature-alert').show();

        } else if (subtype === 'Penthouse' || subtype === 'Room') {
            $('.selection-hide').show();
            $('.btn-hide').hide();
            $('.feature-tag-badge').remove();
        } else if (subtype === 'Residential Plot' || subtype === 'Commercial Plot' || subtype === 'Agricultural Land') {
            $('.selection-hide').hide();
            $('.btn-hide').show();
            if ($('.feature-tag-badge').length == 0)
                $('.feature-alert').show();

        } else {
            $('.selection-hide').hide();
            $('.btn-hide').hide();
            $('.feature-tag-badge').remove();
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
        if ($('input[name="property_subtype-error"]').length > 0 && $('input[name="property_subtype-error"]').val() !== '') {
            // console.log('deit view');
            let value = $('input[name="property_subtype-error"]').val();
            if (value !== 'Penthouse' && value !== 'Room')
                getFeatures(value);
            displayFeatureBtn();
        }


        displayFeatureBtn();
        // to get data for features in edit view

        if ($('#subtype').length > 0) {
            selectValue = $('[name^=property_subtype ]').val();
            let property_index = $('[name=data-index]').val();

            if (selectValue !== 'Penthouse' && selectValue !== 'Room')
                getFeaturesForEdit(selectValue, property_index);
            displayFeatureBtn();
        }

    });
    $(document).on('change', '.selected-feature', function ($this) {
        displayFeatureTag(this);
    });

    $(document).on('click', '.remove-tag', function ($this) {
        event.preventDefault();


        const id = $(this).attr('data-id');
        const type = $(this).attr('data-type');
        if (type === 'checkbox') {
            $("[id='" + id + "']").prop('checked', false);
        }
        if (type === 'number') {
            $("[id='" + id + "']").val('0');
        }
        if (type === 'text') {
            $("[id='" + id + "']").val('');
        }
        if (type === 'select-one') {
            $("[id='" + id + "']").val('').prop('selected', true);
        }

        $(this).parent().remove();
        if ($('.tag-span').length == 0) {
            $('.feature-alert').show();
        }
    });

    function displayFeatureTag(data) {
        if (data.type === 'checkbox' && $("[id='" + data.id + "']").is(":checked")) {
            data.value = "yes";
            const checkbox_html = '<span class="feature-tag-badge badge badge-primary color-white tag-span mx-2 mb-2"><b>' + data.name + '</b><a href="#" class="btn btn-sm remove-tag" data-type="' + data.type + '" data-id="' + data.id + '" data-value= checked"><i class="fas fa-times color-red"></i></a></span>';

            $('.feature-tags').append(checkbox_html);
        } else if (data.type === 'number' && data.value > 0) {
            if ($('a[data-id="' + data.id + '"]').length > 0) {
                $('a[data-id="' + data.id + '"]').parent().remove();

            }
            const number_html = '<span class="feature-tag-badge badge badge-primary color-white tag-span mx-2 mb-2"><b>' + data.name + ': ' + data.value + '</b><a href="#" class="btn btn-sm remove-tag" data-type="' + data.type + '" data-id="' + data.id + '" data-value="' + data.value + '"><i class="fas fa-times color-red"></i></a></span>';
            $('.feature-tags').append(number_html);
        } else if (data.type === 'text' && data.value !== '' && data.value !== 'null' && data.value !== null) {
            if ($('a[data-id="' + data.id + '"]').length > 0) {
                $('a[data-id="' + data.id + '"]').parent().remove();

            }
            const text_html = '<span class="feature-tag-badge badge badge-primary color-white tag-span mx-2 mb-2"><b>' + data.name + ': ' + data.value + '</b><a href="#" class="btn btn-sm remove-tag" data-type="' + data.type + '" data-id="' + data.id + '" data-value="' + data.value + '"><i class="fas fa-times color-red"></i></a></span>';
            $('.feature-tags').append(text_html);

        } else if (data.type === 'select-one') {
            if (data.value !== '') {
                const select_html = '<span class="feature-tag-badge badge badge-primary color-white tag-span mx-2 mb-2"><b>' + data.name + ': ' + data.value + '</b><a href="#" class="btn btn-sm remove-tag" data-type="' + data.type + '" data-id="' + data.id + '" data-value="' + data.value + '"><i class="fas fa-times color-red"></i></a></span>';
                $('.feature-tags').append(select_html);
            }

        } else {
            $('a[data-id="' + data.id + '"]').parent().remove();
        }
        if ($('.tag-span').length > 0) {
            $('.feature-alert').hide();
        }

    }

})
(jQuery);
