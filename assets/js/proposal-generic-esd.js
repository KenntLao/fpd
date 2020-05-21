$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    // Project Name Update
    $('#projectName').change(function () {
        if ($(this).val() != "") {
            $.post("/ajax/esd-generic-proposal-get-values", {
                id: $(this).val()
            }, function (data) {
                if (data.status == "ok") {
                    $('#salutation').val(data.salutation);
                    $('#salutation').change();
                    $('#shortLocation').val(data.shortLocation);
                    $('#shortLocation').change();
                    $('#addressLine1').val(data.addressLine1);
                    $('#addressLine1').change();
                    $('#clientName').val(data.clientName);
                    $('#clientName').change();
                }
            });
        } else {
            $('#salutation').val("");
            $('#salutation').change();
            $('#shortLocation').val("");
            $('#shortLocation').change();
            $('#addressLine1').val("");
            $('#addressLine1').change();
            $('#clientName').val("");
            $('#clientName').change();
        }
    });

    // General UI Functions
    $('#longDate').on('change', function () {
        let d = new Date(Date.parse($('#longDate').val()));

        const months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        if (d.getDate() + " " + months[d.getMonth()] + " " + d.getFullYear() == "NaN undefined NaN") {
            $('.longDatePreview').html("[Long Date]");
        } else {
            $('.longDatePreview').html(d.getDate() + " " + months[d.getMonth()] + " " + d.getFullYear());
        }
    });

    $('#referenceNo').on('keyup', function () {
        if ($(this).val() == "") {
            $('.referenceNoPreview').html('[Reference No]');
        } else {
            $('.referenceNoPreview').html($(this).val());
        }
    }).on("focus", function () {
        $('.referenceNoPreview').addClass('bg-gray-dark');
        $('.referenceNoPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('.referenceNoPreview').addClass('bg-gray-light');
        $('.referenceNoPreview').removeClass('bg-gray-dark');
    });

    // Letter UI Functions

    $('#salutationIntro, #salutation').on("keyup", function () {
        if ($('#salutation').val() == "") {
            $('.salutationPreview').html("[Salutation]");
        } else {
            $('.salutationPreview').html($('#salutationIntro').val() + " " + $('#salutation').val() + ",");
        }
    }).on("change", function () {
        if ($('#salutation').val() == "") {
            $('.salutationPreview').html("[Salutation]");
        } else {
            $('.salutationPreview').html($('#salutationIntro').val() + " " + $('#salutation').val() + ",");
        }
    }).on("focus", function () {
        $('.salutationPreview').addClass('bg-gray-dark');
        $('.salutationPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('.salutationPreview').addClass('bg-gray-light');
        $('.salutationPreview').removeClass('bg-gray-dark');
    });

    $('#serviceType').on('change', function () {
        if (inArray($(this).val(), ['Other Technical Services', 'Subcontracting Services'])) {
            $('#serviceTypeOther').removeAttr('disabled');
            $('#serviceTypePreview').html('[Service Type]');
        } else {
            $('#serviceTypeOther').attr('disabled', 'disabled').val("");
            if ($(this).val() == "") {
                $('#serviceTypePreview').html('[Service Type]');
            } else {
                $('#serviceTypePreview').html($(this).val());
            }
        }
    }).on('focus', function () {
        $('#serviceTypePreview').addClass('bg-gray-dark');
        $('#serviceTypePreview').removeClass('bg-gray-light');
    }).on('blur', function () {
        $('#serviceTypePreview').addClass('bg-gray-light');
        $('#serviceTypePreview').removeClass('bg-gray-dark');
    });


    $('#serviceTypeOther').on('change', function () {
        if ($(this).val() == '') {
            $('#serviceTypePreview').html('[Service Type]');
        } else {
            $('#serviceTypePreview').html($(this).val());
        }
    }).on('keyup', function () {
        if ($(this).val() == '') {
            $('#serviceTypePreview').html('[Service Type]');
        } else {
            $('#serviceTypePreview').html($(this).val());
        }
    }).on('focus', function () {
        $('#serviceTypePreview').addClass('bg-gray-dark');
        $('#serviceTypePreview').removeClass('bg-gray-light');
    }).on('blur', function () {
        $('#serviceTypePreview').addClass('bg-gray-light');
        $('#serviceTypePreview').removeClass('bg-gray-dark');
    });

    $('#shortLocation').on("keyup", function () {
        if ($('#shortLocation').val() == "") {
            $('#shortLocationPreview').html("[Short Location]");
        } else {
            $('#shortLocationPreview').html($('#shortLocation').val());
        }
    }).on("change", function () {
        if ($('#shortLocation').val() == "") {
            $('#shortLocationPreview').html("[Short Location]");
        } else {
            $('#shortLocationPreview').html($('#shortLocation').val());
        }
    }).on("focus", function () {
        $('#shortLocationPreview').addClass('bg-gray-dark');
        $('#shortLocationPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#shortLocationPreview').addClass('bg-gray-light');
        $('#shortLocationPreview').removeClass('bg-gray-dark');
    });

    $('#clientName').on("keyup", function () {
        if ($('#clientName').val() == "") {
            $('#clientNamePreview').html("[Company/Client Name]");
        } else {
            $('#clientNamePreview').html($('#clientName').val());
        }
    }).on("change", function () {
        if ($('#clientName').val() == "") {
            $('#clientNamePreview').html("[Company/Client Name]");
        } else {
            $('#clientNamePreview').html($('#clientName').val());
        }
    }).on("focus", function () {
        $('#clientNamePreview').addClass('bg-gray-dark');
        $('#clientNamePreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#clientNamePreview').addClass('bg-gray-light');
        $('#clientNamePreview').removeClass('bg-gray-dark');
    });

    $('#addressLine1').on("keyup", function () {
        if ($('#addressLine1').val() == "") {
            $('#addressLine1Preview').html("[Address Line 1]");
        } else {
            $('#addressLine1Preview').html($('#addressLine1').val());
        }
    }).on("change", function () {
        if ($('#addressLine1').val() == "") {
            $('#addressLine1Preview').html("[Address Line 1]");
        } else {
            $('#addressLine1Preview').html($('#addressLine1').val());
        }
    }).on("focus", function () {
        $('#addressLine1Preview').addClass('bg-gray-dark');
        $('#addressLine1Preview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#addressLine1Preview').addClass('bg-gray-light');
        $('#addressLine1Preview').removeClass('bg-gray-dark');
    });

    $('#addressLine2').on("keyup", function () {
        if ($('#addressLine2').val() == "") {
            $('#addressLine2Preview').html("[Address Line 2]");
        } else {
            $('#addressLine2Preview').html($('#addressLine2').val());
        }
    }).on("change", function () {
        if ($('#addressLine2').val() == "") {
            $('#addressLine2Preview').html("[Address Line 2]");
        } else {
            $('#addressLine2Preview').html($('#addressLine2').val());
        }
    }).on("focus", function () {
        $('#addressLine2Preview').addClass('bg-gray-dark');
        $('#addressLine2Preview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#addressLine2Preview').addClass('bg-gray-light');
        $('#addressLine2Preview').removeClass('bg-gray-dark');
    });

    $('#letterSubject').on("keyup", function () {
        if ($('#letterSubject').val() == "") {
            $('#letterSubjectPreview').html("[Letter Subject]");
        } else {
            $('#letterSubjectPreview').html($('#letterSubject').val());
        }
    }).on("change", function () {
        if ($('#letterSubject').val() == "") {
            $('#letterSubjectPreview').html("[Letter Subject]");
        } else {
            $('#letterSubjectPreview').html($('#letterSubject').val());
        }
    }).on("focus", function () {
        $('#letterSubjectPreview').addClass('bg-gray-dark');
        $('#letterSubjectPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#letterSubjectPreview').addClass('bg-gray-light');
        $('#letterSubjectPreview').removeClass('bg-gray-dark');
    });

    $('#specialization').on("keyup", function () {
        if ($('#specialization').val() == "") {
            $('#specializationPreview').html("[Specialization]");
        } else {
            $('#specializationPreview').html($('#specialization').val());
        }
    }).on("change", function () {
        if ($('#specialization').val() == "") {
            $('#specializationPreview').html("[Specialization]");
        } else {
            $('#specializationPreview').html($('#specialization').val());
        }
    }).on("focus", function () {
        $('#specializationPreview').addClass('bg-gray-dark');
        $('#specializationPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#specializationPreview').addClass('bg-gray-light');
        $('#specializationPreview').removeClass('bg-gray-dark');
    });

    $('#paymentTerms').on("keyup", function () {
        if ($('#paymentTerms').val() == "") {
            $('#paymentTermsPreview').html("[Payment Terms]");
        } else {
            $('#paymentTermsPreview').html($('#paymentTerms').val());
        }
    }).on("change", function () {
        if ($('#paymentTerms').val() == "") {
            $('#paymentTermsPreview').html("[Payment Terms]");
        } else {
            $('#paymentTermsPreview').html($('#paymentTerms').val());
        }
    }).on("focus", function () {
        $('#paymentTermsPreview').addClass('bg-gray-dark');
        $('#paymentTermsPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#paymentTermsPreview').addClass('bg-gray-light');
        $('#paymentTermsPreview').removeClass('bg-gray-dark');
    });

    $('#proposalValidity').on("keyup", function () {
        if ($('#proposalValidity').val() == "") {
            $('#proposalValidityPreview').html("[Proposal Validity]");
        } else {
            $('#proposalValidityPreview').html($('#proposalValidity').val());
        }
    }).on("change", function () {
        if ($('#proposalValidity').val() == "") {
            $('#proposalValidityPreview').html("[Proposal Validity]");
        } else {
            $('#proposalValidityPreview').html($('#proposalValidity').val());
        }
    }).on("focus", function () {
        $('#proposalValidityPreview').addClass('bg-gray-dark');
        $('#proposalValidityPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#proposalValidityPreview').addClass('bg-gray-light');
        $('#proposalValidityPreview').removeClass('bg-gray-dark');
    });

    $('#warrantyPeriod').on("keyup", function () {
        if ($('#warrantyPeriod').val() == "") {
            $('#warrantyPeriodPreview').html("[Warranty Period]");
        } else {
            $('#warrantyPeriodPreview').html($('#warrantyPeriod').val());
        }
    }).on("change", function () {
        if ($('#warrantyPeriod').val() == "") {
            $('#warrantyPeriodPreview').html("[Warranty Period]");
        } else {
            $('#warrantyPeriodPreview').html($('#warrantyPeriod').val());
        }
    }).on("focus", function () {
        $('#warrantyPeriodPreview').addClass('bg-gray-dark');
        $('#warrantyPeriodPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#warrantyPeriodPreview').addClass('bg-gray-light');
        $('#warrantyPeriodPreview').removeClass('bg-gray-dark');
    });

    $('#conformeSignatoryName').on("keyup", function () {
        if ($('#conformeSignatoryName').val() == "") {
            $('#conformeSignatoryNamePreview').html("[Conforme Signatory Name]");
        } else {
            $('#conformeSignatoryNamePreview').html($('#conformeSignatoryName').val());
        }
    }).on("change", function () {
        if ($('#conformeSignatoryName').val() == "") {
            $('#conformeSignatoryNamePreview').html("[Conforme Signatory Name]");
        } else {
            $('#conformeSignatoryNamePreview').html($('#conformeSignatoryName').val());
        }
    }).on("focus", function () {
        $('#conformeSignatoryNamePreview').addClass('bg-gray-dark');
        $('#conformeSignatoryNamePreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#conformeSignatoryNamePreview').addClass('bg-gray-light');
        $('#conformeSignatoryNamePreview').removeClass('bg-gray-dark');
    });

    $('#conformeSignatoryContact').on("keyup", function () {
        if ($('#conformeSignatoryContact').val() == "") {
            $('#conformeSignatoryContactPreview').html("[Conforme Signatory Contact]");
        } else {
            $('#conformeSignatoryContactPreview').html($('#conformeSignatoryContact').val());
        }
    }).on("change", function () {
        if ($('#conformeSignatoryContact').val() == "") {
            $('#conformeSignatoryContactPreview').html("[Conforme Signatory Contact]");
        } else {
            $('#conformeSignatoryContactPreview').html($('#conformeSignatoryContact').val());
        }
    }).on("focus", function () {
        $('#conformeSignatoryContactPreview').addClass('bg-gray-dark');
        $('#conformeSignatoryContactPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#conformeSignatoryContactPreview').addClass('bg-gray-light');
        $('#conformeSignatoryContactPreview').removeClass('bg-gray-dark');
    });

    $('#signatoryName').on("keyup", function () {
        if ($('#signatoryName').val() == "") {
            $('.signatoryNamePreview').html("[Signatory Name]");
        } else {
            $('.signatoryNamePreview').html($('#signatoryName').val());
        }
    }).on("change", function () {
        if ($('#signatoryName').val() == "") {
            $('.signatoryNamePreview').html("[Signatory Name]");
        } else {
            $('.signatoryNamePreview').html($('#signatoryName').val());
        }
    }).on("focus", function () {
        $('.signatoryNamePreview').addClass('bg-gray-dark');
        $('.signatoryNamePreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('.signatoryNamePreview').addClass('bg-gray-light');
        $('.signatoryNamePreview').removeClass('bg-gray-dark');
    });

    $('#signatoryPosition').on("keyup", function () {
        if ($('#signatoryPosition').val() == "") {
            $('.signatoryPositionPreview').html("[Signatory Position]");
        } else {
            $('.signatoryPositionPreview').html($('#signatoryPosition').val());
        }
    }).on("change", function () {
        if ($('#signatoryPosition').val() == "") {
            $('.signatoryPositionPreview').html("[Signatory Position]");
        } else {
            $('.signatoryPositionPreview').html($('#signatoryPosition').val());
        }
    }).on("focus", function () {
        $('.signatoryPositionPreview').addClass('bg-gray-dark');
        $('.signatoryPositionPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('.signatoryPositionPreview').addClass('bg-gray-light');
        $('.signatoryPositionPreview').removeClass('bg-gray-dark');
    });

    $('#signatoryDepartment').on("keyup", function () {
        if ($('#signatoryDepartment').val() == "") {
            $('.signatoryDepartmentPreview').html("[Signatory Department]");
        } else {
            $('.signatoryDepartmentPreview').html($('#signatoryDepartment').val());
        }
    }).on("change", function () {
        if ($('#signatoryDepartment').val() == "") {
            $('.signatoryDepartmentPreview').html("[Signatory Department]");
        } else {
            $('.signatoryDepartmentPreview').html($('#signatoryDepartment').val());
        }
    }).on("focus", function () {
        $('.signatoryDepartmentPreview').addClass('bg-gray-dark');
        $('.signatoryDepartmentPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('.signatoryDepartmentPreview').addClass('bg-gray-light');
        $('.signatoryDepartmentPreview').removeClass('bg-gray-dark');
    });

    $('#warrantyDisplayPreview').hide();
    $('#warrantyDisplay').click(function () {
        if ($(this).is(':checked')) {
            $('#warrantyDisplayPreview').show();
            $('#warrantyPeriod').removeAttr('disabled');
            $('#warrantyPeriodPreview').html($('#warrantyPeriod').val());
            $('#customWarrantyExplanation').removeAttr('disabled');
        } else {
            $('#warrantyDisplayPreview').hide();
            $('#warrantyPeriod').attr('disabled', 'disabled');
            $('#customWarrantyExplanation').val("");
            $('#customWarrantyExplanation').attr('disabled', 'disabled');

        }
    });

    $('#customWarrantyExplanation').on('keyup', function () {
        if ($(this).val() == "") {
            $('#customWarrantyExplanationPreview').text("[Custom Warranty Explanation]");
        } else {
            $('#customWarrantyExplanationPreview').html($(this).val());
        }
    }).on('change', function () {
        if ($(this).val() == "") {
            $('#customWarrantyExplanationPreview').text("[Custom Warranty Explanation]");
        } else {
            $('#customWarrantyExplanationPreview').html($(this).val());
        }
    }).on('focus', function () {
        $('#customWarrantyExplanationPreview').addClass('bg-gray-dark');
        $('#customWarrantyExplanationPreview').removeClass('bg-gray-light');
    }).on('blur', function () {
        $('#customWarrantyExplanationPreview').addClass('bg-gray-light');
        $('#customWarrantyExplanationPreview').removeClass('bg-gray-dark');
    })

    $('#works').on("keyup", function () {
        if ($('#works').val() == "") {
            $('#worksPreview').html("[Works]");
        } else {
            $('#worksPreview').html($('#works').val());
        }
    }).on("change", function () {
        if ($('#works').val() == "") {
            $('#worksPreview').html("[Works]");
        } else {
            $('#worksPreview').html($('#works').val());
        }
    }).on("focus", function () {
        $('#worksPreview').addClass('bg-gray-dark');
        $('#worksPreview').removeClass('bg-gray-light');
    }).on("blur", function () {
        $('#worksPreview').addClass('bg-gray-light');
        $('#worksPreview').removeClass('bg-gray-dark');
    });

    // Costings UI Functions

    $('.btnAddNewScopeOfWork').on("click", function () {
        let scopeOfWork = $(this).closest(".scopeOfWorks").find('.scopeOfWork').first().clone(true, true);
        scopeOfWork.insertBefore($(this));
        scopeOfWork.find('input[type=text]').val("");
        $(this).parent().find('.scopeOfWork:nth-last-child(2)').find('.material-id').val('0');
    });

    $('.scopeOfWork .btnDelete').on("click", function () {
        if ($(this).closest('.scopeOfWorks').children('.scopeOfWork').length != 1) {
            $(this).closest('.scopeOfWork').remove();
        }
    });

    $('.btnAddNewComputationRow').on('click', function () {
        let computationRow = $(this).closest('.computationRows').find('.computationRow').first().clone(true, true);
        computationRow.find('td:first-child').html($(this).closest('.computationRows').children('.computationRow').length + 1);
        computationRow.find('.rowDescription').val("");
        computationRow.find('.rowMaterialQty').val("");
        computationRow.find('.rowMaterialUnit').val("");
        computationRow.find('.rowMaterialUnitCost').val("");
        computationRow.find('td.rowLaborQty').val("");
        computationRow.find('td.rowLaborUnit').val("");
        computationRow.find('td.rowLaborUnitCost').val("");
        computationRow.insertBefore($(this).parent().parent());
        compute($(this));

        $(this).closest('tr').prev().find('.options-id').val('0');

    });

    $('.computationRow .btnDelete').on('click', function () {
        if ($(this).closest('.computationRows').children('.computationRow').length != 1) {
            let currentComputationRows = $(this).closest('.computationRows');
            $(this).closest('.computationRow').remove();
            let computationRowCtr = 1;
            currentComputationRows.children('.computationRow').each(function () {
                $(this).find('td:first-child').html(computationRowCtr++);
            });
            compute($(this));
        }
    });

    $('.rowMaterialQty, .rowMaterialUnitCost, .rowLaborQty, .rowLaborUnitCost, .computationOther').on('keyup', function () {
        compute($(this));
    });

    $('.rowMaterialQty, .rowLaborQty').on('blur', function () {
        $(this).val(parseInt($(this).val()));
    })

    $('.rowMaterialUnitCost, .rowLaborUnitCost, .computationOther').on('blur', function () {
        $(this).val(parseFloat($(this).val()).toFixed(2));
    })

    $('.btnAddNewCosting').on('click', function () {
        let newCosting = $(this).closest('.costings').find('.costing').first().clone(true, true);
        newCosting.insertBefore($(this));
        newCosting.find('.computationRows').children('.computationRow:not(:first-child)').remove();
        let computationRow = newCosting.find('.computationRows').find('.computationRow:first-child');
        computationRow.find('.rowDescription').val("");
        computationRow.find('.rowMaterialQty').val("");
        computationRow.find('.rowMaterialUnit').val("");
        computationRow.find('.rowMaterialUnitCost').val("");
        computationRow.find('.rowLaborQty').val("");
        computationRow.find('.rowLaborUnit').val("");
        computationRow.find('.rowLaborUnitCost').val("");
        newCosting.find('.computationOther').val("0.00");
        compute($(computationRow));
        sortCostings($(this));

        var labor_cost = $(this).parent().find('.labor-cost-code').val();
        var option_num = 0;
        $(this).parent().find('.option-code').each(function () {
            option_num++;
            $(this).val(labor_cost + option_num);
            $(this).closest('.costing').find('.options-code').each(function () {
                $(this).val(labor_cost + option_num);
            });
        });

        $(this).parent().find('.costing:nth-last-child(2)').find('.lc-id').val('0');
        $(this).parent().find('.costing:nth-last-child(2)').find('.options-id').each(function () {
            $(this).val('0');
        });
    });

    $('.costing thead tr th.btnDelete').on('click', function () {
        let costing = $(this).closest('.costings');
        if ($(this).closest('.costings').children('.costing').length != 1) {
            $(this).closest('.costing').remove();
        }
        sortCostings(costing.children('.costing').first());
    });

    $('.btnAddNewItem').on('click', function () {
        let item = $(this).closest('#items').children('.item:first-child').clone(true, true);
        item.insertBefore($(this));
        item.find('.scopeOfWorks').children('.scopeOfWork:not(:first-child)').remove();
        item.find('.scopeOfWork:first-child input').val("");
        item.find('.input-group input[type=text].itemName').val("");
        item.find('.costings').children('.costing:not(:first-child)').remove();
        let costing = item.find('.costings').find('.costing:first-child');
        costing.find('.computationRows').children('.computationRow:not(:first-child)').remove();
        let computationRow = costing.find('.computationRows').find('.computationRow:first-child');
        computationRow.find('.rowDescription').val("");
        computationRow.find('.rowMaterialQty').val("");
        computationRow.find('.rowMaterialUnit').val("");
        computationRow.find('.rowMaterialUnitCost').val("");
        computationRow.find('.rowLaborQty').val("");
        computationRow.find('.rowLaborUnit').val("");
        computationRow.find('.rowLaborUnitCost').val("");
        costing.find('.computationOther').val("0.00");
        sortCostings(costing);
        compute(costing);
        sortItems($(this));

        var item_code = $(this).parent().find('.item:nth-last-child(3)').find('.item-code').val() * 1 + 1;
        // item
        $(this).parent().find('.item:nth-last-child(2)').find('.item-code').val(item_code);
        $(this).parent().find('.item:nth-last-child(2)').find('.item-id').val('0');
        // material
        $(this).parent().find('.item:nth-last-child(2)').find('.material-code').each(function () {
            $(this).val(item_code);
        });
        $(this).parent().find('.item:nth-last-child(2)').find('.material-id').each(function () {
            $(this).val('0');
        });
        // costings
        $(this).parent().find('.item:nth-last-child(2)').find('.labor-cost-code').each(function () {
            $(this).val(item_code);
        });
        $(this).parent().find('.item:nth-last-child(2)').find('.lc-id').each(function () {
            $(this).val('0');
        });
        // costing
        $(this).parent().find('.item:nth-last-child(2)').find('.costing:nth-last-child(2)').find('.option-code').val(item_code + '1');
        var option_num = 0;
        $(this).parent().find('.item:nth-last-child(2)').find('.costing:nth-last-child(2)').find('.options-code').each(function () {
            option_num++;
            $(this).val(item_code + option_num.toString());
        });
        $(this).parent().find('.item:nth-last-child(2)').find('.costing:nth-last-child(2)').find('.options-id').each(function () {
            $(this).val('0');
        });
    });

    function compute(jqryObj) {
        let computationTable = jqryObj.closest('.costing');
        let computationSubTotalsCost = 0;
        computationTable.find('.computationRows').children('.computationRow').each(function () {
            $(this).find('.rowMaterialAmt').html(
                parseFloat(
                    (parseInt($(this).find('.rowMaterialQty').val()) || 0) *
                    (parseFloat($(this).find('.rowMaterialUnitCost').val()) || 0)
                ).toFixed(2)
            );
            $(this).find('.totalPrice').val(
                parseFloat(
                    (parseInt($(this).find('.rowMaterialQty').val()) || 0) *
                    (parseFloat($(this).find('.rowMaterialUnitCost').val()) || 0)
                ).toFixed(2)
            );
            $(this).find('.rowLaborAmt').html(
                parseFloat(
                    (parseInt($(this).find('.rowLaborQty').val()) || 0) *
                    (parseFloat($(this).find('.rowLaborUnitCost').val()) || 0)
                ).toFixed(2)
            );
            $(this).find('.lcTotalAmount').val(
                parseFloat(
                    (parseInt($(this).find('.rowLaborQty').val()) || 0) *
                    (parseFloat($(this).find('.rowLaborUnitCost').val()) || 0)
                ).toFixed(2)
            );
            let subtotal = (parseFloat($(this).find('.rowMaterialAmt').html()) || 0) + (parseFloat($(this).find('.rowLaborAmt').html()) || 0);
            $(this).find('.rowSubTotal').html(parseFloat(subtotal).toFixed(2));
            $(this).find('.subTotal').val(parseFloat(subtotal).toFixed(2));
            computationSubTotalsCost += subtotal;
        });
        computationTable.find('.computationCost').html(parseFloat(computationSubTotalsCost).toFixed(2));
        computationTable.find('.laborCost').val(parseFloat(computationSubTotalsCost).toFixed(2));
        let computationSubTotalCostTax = computationSubTotalsCost * 0.12;
        computationTable.find('.computationVAT').html(parseFloat(computationSubTotalCostTax).toFixed(2));
        computationTable.find('.vat').val(parseFloat(computationSubTotalCostTax).toFixed(2));
        computationTable.find('.computationProjectCost').html(parseFloat(parseFloat(computationSubTotalCostTax) + parseFloat(computationSubTotalsCost) + parseFloat(parseFloat(computationTable.find('.computationOther').val()) || 0)).toFixed(2));
        computationTable.find('.grandTotal').val(parseFloat(parseFloat(computationSubTotalCostTax) + parseFloat(computationSubTotalsCost) + parseFloat(parseFloat(computationTable.find('.computationOther').val()) || 0)).toFixed(2));

    }

    $('.btnDeleteItem').on('click', function () {
        let items = $(this).closest('#items');
        if ($(this).closest('#items').children('.item').length != 1) {
            $(this).closest('.item').remove();
            sortItems(items.find('.item:first-child'));
        }
    });

    function sortCostings(jqryObj) {
        let costings = jqryObj.closest('.costings');
        let costingCtr = 1;
        costings.children('.costing').each(function () {
            $(this).find('thead').find('tr:first-child').find('th:first-child').html("Costing " + costingCtr++);
        });
    }

    function sortItems(jqryObj) {
        let items = jqryObj.closest('#items');
        let itemsCtr = 1;
        items.children('.item').each(function () {
            $(this).find('.itemCtr').html("Item " + itemsCtr++);
        });
    }

    // Costings Enable
    $('.costingsEnable').click(function () {
        if ($(this).is(':checked')) {
            $(this).closest('.item').find('.costings').show();
            $(this).next('input').val('1');
        } else {
            $(this).closest('.item').find('.costings').hide();
            $(this).next('input').val('0');
        }
    })
});