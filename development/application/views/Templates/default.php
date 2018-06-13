<!DOCTYPE html>
<html>
    <?php $this->load->view('Templates/front_end_head'); ?>
    <script type="text/javascript" src="assets/admin/js/plugins/notifications/sweet_alert.min.js"></script>
    <link href="assets/css/sweet.css" rel="stylesheet" type="text/css"> 
    <script type="text/javascript" src="assets/admin/js/plugins/notifications/sweet_alert.min.js"></script>
    <link href="assets/css/sweet.css" rel="stylesheet" type="text/css">
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-65338411-6', 'auto');
        ga('send', 'pageview');
        $(document).ready(function() {
            email_id = "<?php echo $this->session->userdata('user')['email_id']; ?>";
            user_id = "<?php echo $this->session->userdata('user')['id']; ?>";
            if(email_id == '' && user_id != ''){
                swal({
                    title: "Almost done!",   
                    text: "Please provide us with your email address so we are able to finalize the registration.",   
                    type: "input",   
                    showCancelButton: false,   
                    closeOnConfirm: false,   
                    animation: "slide-from-top",   
                    inputPlaceholder: "Enter email address" 
                }, function(inputValue){   
                    if (inputValue === false) return false;      
                    if (inputValue === "") {     
                        swal.showInputError("You need to write email!");     
                        return false   
                    }
                    if(/^[A-Za-z0-9]/.test(inputValue)){
                        var pattern = /^([a-z\d\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                        if(pattern.test(inputValue)){
                            $.ajax({
                                url: '<?php echo site_url('user/update_email') ?>',
                                data: {email_id : inputValue},
                                type:"POST",
                                success: function(data){
                                    if(data == 'error'){
                                        swal.showInputError("Something went wrong, Please try again!");     
                                    } else {
                                        swal({ 
                                            title: "Success",
                                           text: "Your email address updated!",
                                            type: "success" 
                                        },
                                        function(){
                                            location.reload(); 
                                        });
                                       
                                    }
                                }
                            });
                        } else {
                            swal.showInputError("Invalid email address!");     
                            return false
                        }
                    } else {
                        swal.showInputError("The first character of your email should be a letter (a-z) or number!");     
                        return false
                    }
                });
            }
            $(document).on("contextmenu",'img, #cboxContent #cboxLoadedContent img',function(){
                return false;
            });
            checkLocation();            
        });

        function checkLocation() {
            var location = getCookie("share_location");
            // //--- if user can't have any country then ask to select country
            if (location == "" || location == null) {
                if (navigator.geolocation) {
                    navigator.geolocation.watchPosition(showPosition);
                }
            }
        }

        function showPosition(position) {
            exdays = 30;
            var d = new Date();
            lat = position.coords.latitude;
            long = position.coords.longitude;
            userlocation = position.coords.latitude+','+position.coords.longitude;            
            $.ajax({
                dataType: "json",
                url: 'https://maps.googleapis.com/maps/api/geocode/json',
                data: {latlng : userlocation, sensor : true},
                success: function(data, textStatus){
                    var add = data.results[0].formatted_address
                    var address = {lat: lat, long: long, address: add};
                    display = JSON.stringify(address);
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    var expires = "expires=" + d.toGMTString();
                    document.cookie = 'share_location' + "=" + display + "; " + expires;
                    $('input[data-type="user_current_location"]').val(add);
                    console.log(lat);
                    console.log(long);
                    $('input[data-type="user_current_latitude"]').val(lat);
                    $('input[data-type="user_current_longitude"]').val(long);
                }
            });
        }  

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ')
                    c = c.substring(1);
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            var country = getCookie("selected_country");
            //--- if user can't have any country then ask to select country
            if (country == "" || country == null) {
                //--- show popup for choose country
                $('#user_country_modal').modal({
                    backdrop: 'static',
                    keyboard: false  // to prevent closing with Esc button (if you want this too)
                });
            } else {
                //--- dont't show when user have already country
                $('#user_country_modal').modal('hide');
            }
        }
    </script>
    <body class="hero-content-dark footer-dark" >
        <div class="page-wrapper">
            <?php $this->load->view('Templates/front_end_header'); ?>
            <div class="main">
                <!-- Load Content Start -->
                <?php echo $body; ?>
                <!-- Load Content End -->
            </div><!-- /.main -->
            <?php if (!isset($map_view)) { ?>
                <!--  Footer Part Start -->
                <?php $this->load->view('Templates/front_end_footer'); ?>
                <!--  Footer Part End -->
            <?php } ?>
        </div><!-- /.page-wrapper -->
        <!-- <div class="loading"><div class="loading-div"><img src="assets/images/rolling.gif"></div></div> -->
        <div class="loading"><div class="loading-div"><img src="assets/images/loader1.gif"></div></div>
    </body>
</html>
