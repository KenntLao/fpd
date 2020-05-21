// Round up total hundreds
function round_up_total(total) {
    total = convertCurrency(total);
    var rounded_up = Math.ceil(total / 100) * 100
    return convert_to_currency(rounded_up, "blur");
}


// COMPUTATIONS
// PHIC Computation
function PHIC(salary) {
    salary = convertCurrency(salary);
    var phic = 0;
    if (salary !== 0) {
        phic = 900;
        if (salary > 0 && salary < 60001) {
            phic = (salary * 0.03) / 2;
        }
    }

    return Math.round(phic * 100) / 100;
}
// 13th month pay computation 
function month_13_pay(total_compensation) {
    total_compensation = convertCurrency(total_compensation);
    total_compensation = total_compensation / 12;
    return Math.round(total_compensation * 100) / 100;
}
// RA7641
function RA7641(salary) {
    var RA7641 = 0;
    salary = convertCurrency(salary);
    RA7641 = (salary / 26.167) * (26.167 / 12);
    return Math.round(RA7641 * 100) / 100;
}
// service incentive leave
function service_incentive_leave(salary, cola = 0) {
    var service_incentive = 0;
    salary = convertCurrency(salary);
    cola = convertCurrency(cola);
    service_incentive = ((salary + cola) / 26.167) * 5 / 12;
    return Math.round(service_incentive * 100) / 100;
}
// incentive leave 
function incentive_leave(salary, vl_sl, cola = 0) {
    var incentive = 0;
    salary = convertCurrency(salary);
    cola = convertCurrency(cola);
    vl_sl = convertCurrency(vl_sl);
    incentive = (salary + cola) / 26.167 * vl_sl / 12;
    return Math.round(incentive * 100) / 100;
}
// CHIF
function CHIF(salary) {
    salary = convertCurrency(salary);
    var chif = 0;
    chif = (salary * 0.055) + (salary * 25 / 1000 * 2.54 / 12);
    return Math.round(chif * 100) / 100;
}
// Perfomance Bonus
function performance_bonus(total_compensation) {
    total_compensation = convertCurrency(total_compensation);
    total_compensation = total_compensation / 12;
    return Math.round(total_compensation * 100) / 100;
}
// Relief Pool
function relief_pool(monthly_labor_cost) {
    monthly_labor_cost = convertCurrency(monthly_labor_cost);
    var relief_pool = 0;
    relief_pool = monthly_labor_cost * 0.01;
    return Math.round(relief_pool * 100) / 100;
}
// Admin Overhead
function admin_overhead(sub_total) {
    sub_total = convertCurrency(sub_total);
    var admin_overhead = sub_total * 0.15; // 15% of sub total
    return Math.round(admin_overhead * 100) / 100;
}

// GET TOTALS
// Total compensation
function get_total_compensation(field) {
    var salary = field.closest('tr').find('.salary').val();
    salary = convertCurrency(salary);
    var allowance = field.closest('tr').find('.allowance').val();
    allowance = convertCurrency(allowance);

    var total = salary + allowance;

    field.closest('tr').find('.total-compensation').val(convert_to_currency(total, "blur"));
}
// TOTAL PHIC
function get_phic(field) {
    var salary = field.closest('tr').find('.salary').val();
    field.closest('tr').find('.phic').val(PHIC(salary));
    formatCurrency(field.closest('tr').find('.phic'), "blur");
}
//  get 13th Month Pay
function get_13_month(field) {
    var total_compensation = field.closest('tr').find('.total-compensation').val();
    field.closest('tr').find('.month-13').val(month_13_pay(total_compensation));
    formatCurrency(field.closest('tr').find('.month-13'), "blur");
}
// get RA 7641
function get_ra_7641(field) {
    var salary = field.closest('tr').find('.salary').val();
    field.closest('tr').find('.RA-7641').val(RA7641(salary));
    formatCurrency(field.closest('tr').find('.RA-7641'), "blur");
}
// get service incentive leave
function get_service_incentive_leave(field) {
    var salary = field.closest('tr').find('.salary').val();
    var service_incentive = service_incentive_leave(salary);
    field.closest('tr').find('.service-incentive-leave').val(convert_to_currency(service_incentive, "blur"));
}

// TOTAL GMB
function get_total_gmb(field) {
    var sss = field.closest('tr').find('.sss').val();
    sss = convertCurrency(sss);
    var ecc = field.closest('tr').find('.ecc').val();
    ecc = convertCurrency(ecc);
    var phic = field.closest('tr').find('.phic').val();
    phic = convertCurrency(phic);
    var hdmf = field.closest('tr').find('.hdmf').val();
    hdmf = convertCurrency(hdmf);
    var month_13 = field.closest('tr').find('.month-13').val();
    month_13 = convertCurrency(month_13);
    var RA_7641 = field.closest('tr').find('.RA-7641').val();
    RA_7641 = convertCurrency(RA_7641);
    var nd = field.closest('tr').find('.nd').val();
    nd = convertCurrency(nd);
    var service_incentive = field.closest('tr').find('.service-incentive-leave').val();
    service_incentive = convertCurrency(service_incentive);

    var total = sss + ecc + phic + hdmf + month_13 + RA_7641 + nd + service_incentive;
    field.closest('tr').find('.total-gmb').val(total);
    formatCurrency(field.closest('tr').find('.total-gmb'), "blur");
}
// TOTAL INCENTIVE LEAVE
function get_incentive_leave(field, code) {
    var salary = field.closest('tr').find('.salary').val();
    var vl_sl = field.closest('tr').find('.vl-sl').val();

    // position code with *1.3 incentive leave
    var position_codes = ['MST I', 'MST II', 'MST III', 'LT I'];

    var incentive = incentive_leave(salary, vl_sl);
    if (inArray(code, position_codes)) {
        incentive = incentive * 1.3;
    }

    field.closest('tr').find('.incentive-leave').val(incentive);
    formatCurrency(field.closest('tr').find('.incentive-leave'), "blur");
}
// TOTAL CHIF
function get_chif(field) {
    var salary = field.closest('tr').find('.salary').val();
    field.closest('tr').find('.chif').val(CHIF(salary));
    formatCurrency(field.closest('tr').find('.chif'), "blur");
}
// TOTAL PERFORMANCE BONUS
function get_performance_bonus(field) {
    var total_compensation = field.closest('tr').find('.total-compensation').val();
    field.closest('tr').find('.performance-bonus').val(performance_bonus(total_compensation));
    formatCurrency(field.closest('tr').find('.performance-bonus'), "blur");
}
// TOTAL CIB
function get_total_cib(field) {
    var incentive_leave = field.closest('tr').find('.incentive-leave').val();
    incentive_leave = convertCurrency(incentive_leave);
    var chif = field.closest('tr').find('.chif').val();
    chif = convertCurrency(chif);
    var uniform = field.closest('tr').find('.uniform').val();
    uniform = convertCurrency(uniform);
    var office_activities = field.closest('tr').find('.office-activities').val();
    office_activities = convertCurrency(office_activities);
    var performance_bonus = field.closest('tr').find('.performance-bonus').val();
    performance_bonus = convertCurrency(performance_bonus);

    var total = incentive_leave + chif + uniform + office_activities + performance_bonus;
    field.closest('tr').find('.total-cib').val(total);
    formatCurrency(field.closest('tr').find('.total-cib'), "blur");
}
// OUTSOURCE TOTAL CIB
function get_outsource_total_cib(field) {
    var incentive_leave = field.closest('tr').find('.incentive-leave').val();
    incentive_leave = convertCurrency(incentive_leave);
    var insurance = field.closest('tr').find('.insurance').val();
    insurance = convertCurrency(insurance);
    var uniform = field.closest('tr').find('.uniform').val();
    uniform = convertCurrency(uniform);

    var total = incentive_leave + insurance + uniform;
    field.closest('tr').find('.total-cib').val(convert_to_currency(total, "blur"));
}
// OUTSOURCE SUB TOTAL
function get_sub_total(field) {
    var total_compensation = field.closest('tr').find('.total-compensation').val();
    total_compensation = convertCurrency(total_compensation);
    var total_gmb = field.closest('tr').find('.total-gmb').val();
    total_gmb = convertCurrency(total_gmb);
    var total_cib = field.closest('tr').find('.total-cib').val();
    total_cib = convertCurrency(total_cib);

    var sub_total = total_compensation + total_gmb + total_cib;
    sub_total = Math.round(sub_total * 100) / 100;
    field.closest('tr').find('.sub-total').val(convert_to_currency(sub_total, "blur"));
}
//OUTSOURCE ADMIN OVERHEAD
function get_admin_overhead(field) {
    var sub_total = field.closest('tr').find('.sub-total').val();
    var overhead = admin_overhead(sub_total);
    field.closest('tr').find('.admin-overhead').val(convert_to_currency(overhead, "blur"));
}
// OUTSOURCE TOTAL MONTHLY LABOR COST
function get_outsource_monthly_labor_cost(field) {
    var sub_total = field.closest('tr').find('.sub-total').val();
    sub_total = convertCurrency(sub_total);
    var overhead = field.closest('tr').find('.admin-overhead').val();
    overhead = convertCurrency(overhead);

    var total_lc = sub_total + overhead;
    total_lc = Math.round(total_lc * 100) / 100;
    field.closest('tr').find('.monthly-labor-cost').val(convert_to_currency(total_lc, "blur"));
}

// TOTAL MONTHLY LABOR COST
function get_monthly_labor_cost(field) {
    var total_compensation = field.closest('tr').find('.total-compensation').val();
    total_compensation = convertCurrency(total_compensation);
    var total_gmb = field.closest('tr').find('.total-gmb').val();
    total_gmb = convertCurrency(total_gmb);
    var total_cib = field.closest('tr').find('.total-cib').val();
    total_cib = convertCurrency(total_cib);

    var total = total_compensation + total_gmb + total_cib;
    field.closest('tr').find('.monthly-labor-cost').val(total);
    formatCurrency(field.closest('tr').find('.monthly-labor-cost'), "blur");
}
// TOTAL RELIEF POOL
function get_relief_pool(field) {
    var monthly_labor_cost = field.closest('tr').find('.monthly-labor-cost').val();
    monthly_labor_cost = convertCurrency(monthly_labor_cost);
    field.closest('tr').find('.relief-pool').val(relief_pool(monthly_labor_cost));
    formatCurrency(field.closest('tr').find('.relief-pool'), "blur");
}
// TOTAL
function get_total(field) {
    var monthly_labor_cost = field.closest('tr').find('.monthly-labor-cost').val();
    monthly_labor_cost = convertCurrency(monthly_labor_cost);
    var relief_pool = field.closest('tr').find('.relief-pool').val();
    relief_pool = convertCurrency(relief_pool);

    var total = monthly_labor_cost + relief_pool;
    field.closest('tr').find('.total').val(total);
    formatCurrency(field.closest('tr').find('.total'), "blur");
}
// TOTAL ROUND UP TOTAL
function get_total_round_up_total(field) {
    var total = field.closest('tr').find('.total').val();
    total = round_up_total(total);
    field.closest('tr').find('.round-up-total').val(total);
}

function get_outsource_rounded_up_total(field) {
    var total = field.closest('tr').find('.monthly-labor-cost').val();
    total = round_up_total(total);
    field.closest('tr').find('.round-up-total').val(total);
}

// OVERALL TOTALS
function compute_all_total() {
    // salary
    $('.total_salary').each(function () {
        var total_salary = 0;
        $(this).closest('table').find('.salary').each(function () {
            var salary = $(this).val();
            salary = convertCurrency(salary);
            total_salary += salary;
        });
        $(this).html(convert_to_currency(total_salary.toFixed(3), "blur"));
    });

    // allowance
    $('.total_allowance').each(function () {
        var total_allowance = 0;
        $(this).closest('table').find('.allowance').each(function () {
            var allowance = $(this).val();
            allowance = convertCurrency(allowance);
            total_allowance += allowance;
        });
        $(this).html(convert_to_currency(total_allowance.toFixed(3), "blur"));
    });

    // compensation
    $('.compensation_total').each(function () {
        var compensation_total = 0;
        $(this).closest('table').find('.total-compensation').each(function () {
            var compensation = $(this).val();
            compensation = convertCurrency(compensation);
            compensation_total += compensation;
        });
        $(this).html(convert_to_currency(compensation_total.toFixed(3), "blur"));
    });

    // sss
    $('.total_sss').each(function () {
        var total_sss = 0;
        $(this).closest('table').find('.sss').each(function () {
            var sss = $(this).val();
            sss = convertCurrency(sss);
            total_sss += sss;
        });
        $(this).html(convert_to_currency(total_sss.toFixed(3), "blur"));
    });

    // ecc
    $('.total_ecc').each(function () {
        var total_ecc = 0;
        $(this).closest('table').find('.ecc').each(function () {
            var ecc = $(this).val();
            ecc = convertCurrency(ecc);
            total_ecc += ecc;
        });
        $(this).html(convert_to_currency(total_ecc.toFixed(3), "blur"));
    });

    // phic
    $('.total_phic').each(function () {
        var total_phic = 0;
        $(this).closest('table').find('.phic').each(function () {
            var phic = $(this).val();
            phic = convertCurrency(phic);
            total_phic += phic;
        });
        $(this).html(convert_to_currency(total_phic.toFixed(3), "blur"));
    });

    // hdmf
    $('.total_hdmf').each(function () {
        var total_hdmf = 0;
        $(this).closest('table').find('.hdmf').each(function () {
            var hdmf = $(this).val();
            hdmf = convertCurrency(hdmf);
            total_hdmf += hdmf;
        });
        $(this).html(convert_to_currency(total_hdmf.toFixed(3), "blur"));
    });

    // 13_month
    $('.total_13_month').each(function () {
        var total_13_month = 0;
        $(this).closest('table').find('.month-13').each(function () {
            var month_13 = $(this).val();
            month_13 = convertCurrency(month_13);
            total_13_month += month_13;
        });
        $(this).html(convert_to_currency(total_13_month.toFixed(3), "blur"));
    });

    // RA 7641
    $('.total_RA_7641').each(function () {
        var total_RA_7641 = 0;
        $(this).closest('table').find('.RA-7641').each(function () {
            var ra_7641 = $(this).val();
            ra_7641 = convertCurrency(ra_7641);
            total_RA_7641 += ra_7641;
        });
        $(this).html(convert_to_currency(total_RA_7641.toFixed(3), "blur"));
    });

    // TOTAL NIGHT DUTY
    $('.total_night_duty').each(function () {
        var total_night_duty = 0;
        $(this).closest('table').find('.night-duty').each(function () {
            var night_duty = $(this).val();
            total_night_duty += night_duty * 1;
        });
        $(this).html(convert_to_currency(total_night_duty.toFixed(3), "blur"));
    });

    // TOTAL SERVICE INCENTIVE LEAVE
    $('.total_service_incentive_leave').each(function () {
        var total_service_incentive_leave = 0;
        $(this).closest('table').find('.service-incentive-leave').each(function () {
            var service_incentive_leave = $(this).val();
            service_incentive_leave = convertCurrency(service_incentive_leave);
            total_service_incentive_leave += service_incentive_leave;
        });
        $(this).html(convert_to_currency(total_service_incentive_leave.toFixed(3), "blur"));
    });

    // TOTAL GMB
    $('.gmb_total').each(function () {
        var gmb_total = 0;
        $(this).closest('table').find('.total-gmb').each(function () {
            var total_gmb = $(this).val();
            total_gmb = convertCurrency(total_gmb);
            gmb_total += total_gmb;
        });
        $(this).html(convert_to_currency(gmb_total.toFixed(3), "blur"));
    });

    // incentive leave
    $('.total_incentive_leave').each(function () {
        var total_incentive_leave = 0;
        $(this).closest('table').find('.incentive-leave').each(function () {
            var incentive_leave = $(this).val();
            incentive_leave = convertCurrency(incentive_leave);
            total_incentive_leave += incentive_leave;
        });
        $(this).html(convert_to_currency(total_incentive_leave.toFixed(3), "blur"));
    });

    // chif
    $('.total_chif').each(function () {
        var total_chif = 0;
        $(this).closest('table').find('.chif').each(function () {
            var chif = $(this).val();
            chif = convertCurrency(chif);
            total_chif += chif;
        });
        $(this).html(convert_to_currency(total_chif.toFixed(3), "blur"));
    });

    // uniform
    $('.total_uniform').each(function () {
        var total_uniform = 0;
        $(this).closest('table').find('.uniform').each(function () {
            var uniform = $(this).val();
            uniform = convertCurrency(uniform);
            total_uniform += uniform;
        });
        $(this).html(convert_to_currency(total_uniform.toFixed(3), "blur"));
    });

    // office_activities
    $('.total_office_activities').each(function () {
        var total_office_activities = 0;
        $(this).closest('table').find('.office-activities').each(function () {
            var office_activities = $(this).val();
            office_activities = convertCurrency(office_activities);
            total_office_activities += office_activities;
        });
        $(this).html(convert_to_currency(total_office_activities.toFixed(3), "blur"));
    });

    // performance bonus
    $('.total_performance_bonus').each(function () {
        var total_performance_bonus = 0;
        $(this).closest('table').find('.performance-bonus').each(function () {
            var performance_bonus = $(this).val();
            performance_bonus = convertCurrency(performance_bonus);
            total_performance_bonus += performance_bonus;
        });
        $(this).html(convert_to_currency(total_performance_bonus.toFixed(3), "blur"));
    });

    // TOTAL CIB
    $('.cib_total').each(function () {
        var cib_total = 0;
        $(this).closest('table').find('.total-cib').each(function () {
            var total_cib = $(this).val();
            total_cib = convertCurrency(total_cib);
            cib_total += total_cib;
        });
        $(this).html(convert_to_currency(cib_total.toFixed(3), "blur"));
    });

    // monthly labor cost
    $('.total_monthly_labor_cost').each(function () {
        var total_monthly_labor_cost = 0;
        $(this).closest('table').find('.monthly-labor-cost').each(function () {
            var monthly_labor_cost = $(this).val();
            monthly_labor_cost = convertCurrency(monthly_labor_cost);
            total_monthly_labor_cost += monthly_labor_cost;
        });
        $(this).html(convert_to_currency(total_monthly_labor_cost.toFixed(3), "blur"));
    });

    // relief_pool
    $('.total_relief_pool').each(function () {
        var total_relief_pool = 0;
        $(this).closest('table').find('.relief-pool').each(function () {
            var relief_pool = $(this).val();
            relief_pool = convertCurrency(relief_pool);
            total_relief_pool += relief_pool;
        });
        $(this).html(convert_to_currency(total_relief_pool.toFixed(3), "blur"));
    });

    // total
    $('.total_total').each(function () {
        var total_total = 0;
        $(this).closest('table').find('.total').each(function () {
            var total = $(this).val();
            total = convertCurrency(total);
            total_total += total;
        });
        $(this).html(convert_to_currency(total_total.toFixed(3), "blur"));
    });

    // round_up_total
    $('.total_round_up_total').each(function () {
        var total_round_up_total = 0;
        $(this).closest('table').find('.round-up-total').each(function () {
            var round_up_total = $(this).val();
            round_up_total = convertCurrency(round_up_total);
            total_round_up_total += round_up_total;
        });
        $(this).html(convert_to_currency(total_round_up_total.toFixed(3), "blur"));
    });
}

function compute_outsource_all_total() {
    // salary
    $('.total_salary').each(function () {
        var total_salary = 0;
        $(this).closest('table').find('.salary').each(function () {
            var salary = $(this).val();
            salary = convertCurrency(salary);
            total_salary += salary;
        });
        $(this).html(convert_to_currency(total_salary.toFixed(3), "blur"));
    });

    // allowance
    $('.total_allowance').each(function () {
        var total_allowance = 0;
        $(this).closest('table').find('.allowance').each(function () {
            var allowance = $(this).val();
            allowance = convertCurrency(allowance);
            total_allowance += allowance;
        });
        $(this).html(convert_to_currency(total_allowance.toFixed(3), "blur"));
    });

    // compensation
    $('.compensation_total').each(function () {
        var compensation_total = 0;
        $(this).closest('table').find('.total-compensation').each(function () {
            var compensation = $(this).val();
            compensation = convertCurrency(compensation);
            compensation_total += compensation;
        });
        $(this).html(convert_to_currency(compensation_total.toFixed(3), "blur"));
    });

    // sss
    $('.total_sss').each(function () {
        var total_sss = 0;
        $(this).closest('table').find('.sss').each(function () {
            var sss = $(this).val();
            sss = convertCurrency(sss);
            total_sss += sss;
        });
        $(this).html(convert_to_currency(total_sss.toFixed(3), "blur"));
    });

    // ecc
    $('.total_ecc').each(function () {
        var total_ecc = 0;
        $(this).closest('table').find('.ecc').each(function () {
            var ecc = $(this).val();
            ecc = convertCurrency(ecc);
            total_ecc += ecc;
        });
        $(this).html(convert_to_currency(total_ecc.toFixed(3), "blur"));
    });

    // phic
    $('.total_phic').each(function () {
        var total_phic = 0;
        $(this).closest('table').find('.phic').each(function () {
            var phic = $(this).val();
            phic = convertCurrency(phic);
            total_phic += phic;
        });
        $(this).html(convert_to_currency(total_phic.toFixed(3), "blur"));
    });

    // hdmf
    $('.total_hdmf').each(function () {
        var total_hdmf = 0;
        $(this).closest('table').find('.hdmf').each(function () {
            var hdmf = $(this).val();
            hdmf = convertCurrency(hdmf);
            total_hdmf += hdmf;
        });
        $(this).html(convert_to_currency(total_hdmf.toFixed(3), "blur"));
    });

    // 13_month
    $('.total_13_month').each(function () {
        var total_13_month = 0;
        $(this).closest('table').find('.month-13').each(function () {
            var month_13 = $(this).val();
            month_13 = convertCurrency(month_13);
            total_13_month += month_13;
        });
        $(this).html(convert_to_currency(total_13_month.toFixed(3), "blur"));
    });

    // RA 7641
    $('.total_RA_7641').each(function () {
        var total_RA_7641 = 0;
        $(this).closest('table').find('.RA-7641').each(function () {
            var ra_7641 = $(this).val();
            ra_7641 = convertCurrency(ra_7641);
            total_RA_7641 += ra_7641;
        });
        total_RA_7641 = (total_RA_7641 * 100) / 100;
        $(this).html(convert_to_currency(total_RA_7641.toFixed(3), "blur"));
    });

    // TOTAL NIGHT DUTY
    $('.total_night_duty').each(function () {
        var total_night_duty = 0;
        $(this).closest('table').find('.night-duty').each(function () {
            var night_duty = $(this).val();
            total_night_duty += night_duty * 1;
        });
        $(this).html(convert_to_currency(total_night_duty.toFixed(3), "blur"));
    });

    // TOTAL SERVICE INCENTIVE LEAVE
    $('.total_service_incentive_leave').each(function () {
        var total_service_incentive_leave = 0;
        $(this).closest('table').find('.service-incentive-leave').each(function () {
            var service_incentive_leave = $(this).val();
            service_incentive_leave = convertCurrency(service_incentive_leave);
            total_service_incentive_leave += service_incentive_leave;
        });
        $(this).html(convert_to_currency(total_service_incentive_leave.toFixed(3), "blur"));
    });

    // TOTAL GMB
    $('.gmb_total').each(function () {
        var gmb_total = 0;
        $(this).closest('table').find('.total-gmb').each(function () {
            var total_gmb = $(this).val();
            total_gmb = convertCurrency(total_gmb);
            gmb_total += total_gmb;
        });
        $(this).html(convert_to_currency(gmb_total.toFixed(3), "blur"));
    });

    // incentive leave
    $('.total_incentive_leave').each(function () {
        var total_incentive_leave = 0;
        $(this).closest('table').find('.incentive-leave').each(function () {
            var incentive_leave = $(this).val();
            incentive_leave = convertCurrency(incentive_leave);
            total_incentive_leave += incentive_leave;
        });
        $(this).html(convert_to_currency(total_incentive_leave.toFixed(3), "blur"));
    });

    // Insurance
    $('.total_insurance').each(function () {
        var total_insurance = 0;
        $(this).closest('table').find('.insurance').each(function () {
            var insurance = $(this).val();
            insurance = convertCurrency(insurance);
            total_insurance += insurance;
        });
        $(this).html(convert_to_currency(total_insurance.toFixed(3), "blur"));
    });

    // uniform
    $('.total_uniform').each(function () {
        var total_uniform = 0;
        $(this).closest('table').find('.uniform').each(function () {
            var uniform = $(this).val();
            uniform = convertCurrency(uniform);
            total_uniform += uniform;
        });
        $(this).html(convert_to_currency(total_uniform.toFixed(3), "blur"));
    });

    // TOTAL CIB
    $('.cib_total').each(function () {
        var cib_total = 0;
        $(this).closest('table').find('.total-cib').each(function () {
            var total_cib = $(this).val();
            total_cib = convertCurrency(total_cib);
            cib_total += total_cib;
        });
        $(this).html(convert_to_currency(cib_total.toFixed(3), "blur"));
    });

    // SUB TOTAL
    $('.total_sub_total').each(function () {
        var total_sub_total = 0;
        $(this).closest('table').find('.sub-total').each(function () {
            var sub_total = $(this).val();
            sub_total = convertCurrency(sub_total);
            total_sub_total += sub_total;
        });
        $(this).html(convert_to_currency(total_sub_total.toFixed(3), "blur"));
    });

    // ADMIN OVERHEAD
    $('.total_admin_overhead').each(function () {
        var total_admin_overhead = 0;
        $('.admin-overhead').each(function () {
            var admin_overhead = $(this).val();
            admin_overhead = convertCurrency(admin_overhead);
            total_admin_overhead += admin_overhead;
        });
        $(this).html(convert_to_currency(total_admin_overhead.toFixed(3), "blur"));
    });

    // MONTHLY LABOR COST
    $('.total_monthly_labor_cost').each(function () {
        var total_monthly_labor_cost = 0;
        $(this).closest('table').find('.monthly-labor-cost').each(function () {
            var monthly_labor_cost = $(this).val();
            monthly_labor_cost = convertCurrency(monthly_labor_cost);
            total_monthly_labor_cost += monthly_labor_cost;
        });
        $(this).html(convert_to_currency(total_monthly_labor_cost.toFixed(3), "blur"));
        $(this).next().val(convert_to_currency(total_monthly_labor_cost.toFixed(3), "blur"));
    });

    // ROUNDED UP TOTAL
    $('.total_round_up_total').each(function () {
        var total_round_up_total = 0;
        $(this).closest('table').find('.round-up-total').each(function () {
            var round_up_total = $(this).val();
            round_up_total = convertCurrency(round_up_total);
            total_round_up_total += round_up_total;
        });
        $(this).html(convert_to_currency(total_round_up_total.toFixed(3), "blur"));
        $(this).next().val(convert_to_currency(total_round_up_total.toFixed(3), "blur"));
    });
}

function compute_combined_total() {
    $('.total_monthly_labor_cost').each(function () {
        var total_monthly_labor_cost = 0;
        $(this).closest('table').find('.month-lc').each(function () {
            var monthly_labor_cost = $(this).val();
            monthly_labor_cost = convertCurrency(monthly_labor_cost);
            total_monthly_labor_cost += monthly_labor_cost;
        });
        $(this).html(convert_to_currency(total_monthly_labor_cost.toFixed(3), "blur"));
    });

    $('.total_total').each(function () {
        var total_total = 0;
        $(this).closest('table').find('.lc-total').each(function () {
            var total = $(this).val();
            total = convertCurrency(total);
            total_total += total;
        });
        $(this).html(convert_to_currency(total_total.toFixed(3), "blur"));
    });

}

// all computation
function compute(field, code) {

    var $this = field;

    get_total_compensation($this);
    get_phic($this);
    get_13_month($this);
    get_ra_7641($this);
    get_service_incentive_leave($this);
    get_total_gmb($this);
    get_incentive_leave($this, code);
    get_chif($this);
    get_performance_bonus($this);
    get_total_cib($this);
    get_monthly_labor_cost($this);
    get_relief_pool($this);
    get_total($this);
    get_total_round_up_total($this);

    compute_all_total();

}

// outsource all computation
function compute_outsource(field) {

    var $this = field;
    var code = '';

    get_total_compensation($this);
    get_phic($this);
    get_13_month($this);
    get_ra_7641($this);
    get_service_incentive_leave($this);
    get_total_gmb($this);
    get_incentive_leave($this, code);
    get_outsource_total_cib($this);
    get_sub_total($this);
    get_admin_overhead($this);
    get_outsource_monthly_labor_cost($this);
    get_outsource_rounded_up_total($this);

    compute_outsource_all_total();
}