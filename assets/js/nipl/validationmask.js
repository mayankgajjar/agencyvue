
jQuery(function ($) {
//    $("#cuscontact").mask("(999) 999-9999");
    $(".custom_phone_number_marks").mask("(999) 999-9999");
    $("#phonecontact").mask("(999) 999-9999");
    $(".custome_zipcode").mask("99999");
    $("#cuszip").mask("99999");
    $("#business_zip").mask("99999");
    $("#comm_zip").mask("99999");
    $(".cusfaxnumber").mask("(999) 999-9999");
    $(".securitynumber").mask("999-99-9999");
    $(".federal_tax_id").mask("99-9999999");
    $("#custnumber").mask("(999) 999-9999");
    $(".child_zipcode").mask("99999");
    $(".child_phone_number").mask("(999) 999-9999");
    $(".child_social_security_number").mask("999-99-9999");
    $(document).on("focusin", function () {
        $(".child_zipcode").mask("99999");
        $(".child_social_security_number").mask("999-99-9999");
        $(".child_phone_number").mask("(999) 999-9999");
    });

});
