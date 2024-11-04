jQuery(function ($) {
    $(document).ready(function () {
        if ($('#partners').length) {

            const ajaxData = {
                partnerName: '',
                partnerType: [],
                paymentType: [],
            }

            let checkboxItems = $('.checkbox-filter').find('.checkbox-item'),
                selectItems = $('.select-block').find('.checkbox-item'),
                selectHead = $('.select-block').find('.select-block--head .select-placeholder'),
                inputText = $('.submit-block').find("input[type='text']"),
                filterSubmit = $('#filter-submit'),
                eventClick = $( window ).width() > 1024 ? 'click' : 'touchstart',
                partnerName;

            // Checkbox block handler
            checkboxItems.each((id, el) => {
                $(el).on(eventClick, function () {
                    $(this).find('.checkbox').toggleClass('checked');

                    // Clear previous values to avoid duplicates
                    ajaxData.partnerType = [];
                    ajaxData.paymentType = [];

                    if (partnerName) {
                        ajaxData.partnerName = partnerName;
                    }

                    checkboxItems.each(function (is, el) {
                        if ($(el).children('.checkbox').hasClass('checked')) {
                            const value = $(el).children('.checkbox').data('value');
                            if (!ajaxData.partnerType.includes(value)) {
                                ajaxData.partnerType.push(value);
                            }
                        }
                    });

                    selectItems.each(function (is, el) {
                        if ($(el).children('.checkbox').hasClass('checked')) {
                            const value = $(el).children('.checkbox').data('value');
                            if (!ajaxData.paymentType.includes(value)) {
                                ajaxData.paymentType.push(value);
                            }
                        }
                    });

                    selectHead.parent().removeClass('is-opened');

                    $.ajax({
                        url: ajax_object.ajax_url,
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: {
                            action: 'partners_filter',
                            partnerName: ajaxData.partnerName,
                            partnerType: JSON.stringify(ajaxData.partnerType),
                            paymentType: JSON.stringify(ajaxData.paymentType)
                        },
                        success: function(response) {
                            $('.partners__container').html(response.html);
                        },
                        error: function (e) {
                            console.log('error', e);
                        },
                    });
                });
            })

            // Open select options
            selectHead.on(eventClick, function () {
                $(this).parent().toggleClass('is-opened');
            });

            // Select block handler
            selectItems.each((id, el) => {
                $(el).on(eventClick, function () {
                    if ($(this).find('.checkbox').data('value') === 'all') {
                        selectItems.find('.checkbox').removeClass('checked');
                        $(this).find('.checkbox').toggleClass('checked');
                        selectItems.find('.checkbox').toggleClass('checked');
                    } else {
                        selectItems.find(`[data-value='all']`).removeClass('checked');
                    }
                    $(this).find('.checkbox').toggleClass('checked');

                    // Clear previous values to avoid duplicates
                    ajaxData.partnerType = [];
                    ajaxData.paymentType = [];

                    if (partnerName) {
                        ajaxData.partnerName = partnerName;
                    }

                    checkboxItems.each(function (is, el) {
                        if ($(el).children('.checkbox').hasClass('checked')) {
                            const value = $(el).children('.checkbox').data('value');
                            if (!ajaxData.partnerType.includes(value)) {
                                ajaxData.partnerType.push(value);
                            }
                        }
                    });

                    selectItems.each(function (is, el) {
                        if ($(el).children('.checkbox').hasClass('checked')) {
                            const value = $(el).children('.checkbox').data('value');
                            if (!ajaxData.paymentType.includes(value)) {
                                ajaxData.paymentType.push(value);
                            }
                        }
                    });


                    $.ajax({
                        url: ajax_object.ajax_url,
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        data: {
                            action: 'partners_filter',
                            partnerName: ajaxData.partnerName,
                            partnerType: JSON.stringify(ajaxData.partnerType),
                            paymentType: JSON.stringify(ajaxData.paymentType)
                        },
                        success: function(response) {
                            $('.partners__container').html(response.html);
                        },
                        error: function (e) {
                            console.log('error', e);
                        },
                    });

                });
            })

            // Search field typing
            inputText.on('keyup', function (e) {
                partnerName = e.currentTarget.value;
                if (e.currentTarget.value.length === 0) {
                    ajaxData.partnerName = '';
                }
            })

            // Submit button handler
            filterSubmit.on(eventClick, function (e) {
                e.preventDefault();

                // Clear previous values to avoid duplicates
                ajaxData.partnerType = [];
                ajaxData.paymentType = [];

                if (partnerName) {
                    ajaxData.partnerName = partnerName;
                }

                checkboxItems.each(function (is, el) {
                    if ($(el).children('.checkbox').hasClass('checked')) {
                        const value = $(el).children('.checkbox').data('value');
                        if (!ajaxData.partnerType.includes(value)) {
                            ajaxData.partnerType.push(value);
                        }
                    }
                });

                selectItems.each(function (is, el) {
                    if ($(el).children('.checkbox').hasClass('checked')) {
                        const value = $(el).children('.checkbox').data('value');
                        if (!ajaxData.paymentType.includes(value)) {
                            ajaxData.paymentType.push(value);
                        }
                    }
                });

                selectHead.parent().removeClass('is-opened');

                $.ajax({
                    url: ajax_object.ajax_url,
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    data: {
                        action: 'partners_filter',
                        partnerName: ajaxData.partnerName,
                        partnerType: JSON.stringify(ajaxData.partnerType),
                        paymentType: JSON.stringify(ajaxData.paymentType)
                    },
                    success: function(response) {
                        $('.partners__container').html(response.html);
                    },
                    error: function (e) {
                        console.log('error', e);
                    },
                });
            });
        }
    });
});