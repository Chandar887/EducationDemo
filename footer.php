<div class="footer">
    <div class="container">
        <div class="about-us-foot">
            <h6><span>W</span>ebcyst</h6>
            <p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
        <div class="social-media"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-google"></i></a><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
        <div class="payment">
            <ul>
                <li><img src="assets/img/paypal.png" alt=""></li>
                <li><img src="assets/img/mastercard.png" alt=""></li>
                <li><img src="assets/img/americanexpress.png" alt=""></li>
                <li><img src="assets/img/visaelectron.png" alt=""></li>
            </ul>
        </div>
        <div class="copyright"><span>© 2016 All Right Reserved</span></div>
    </div>
</div>

<script src="assets/js/jquery-3.1.0.min.js"></script>
<script src="assets/js/materialize.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="adminpanel/assets/js/jquery-confirm.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.logout').click(function () {
            // var ele = $(this);
            // var loginid = ele.attr('userid');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            type: "POST",
                            url: "controller/ajaxcontroller.php",
                            data: {req_type: "logoutuser"},
                            // dataType: "json",	
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
//                                         alert(obj.data);
                                // console.log(data);
                                if (obj.data == 1)
                                {
                                    window.location = "index.php";
                                }
                            }
                        });
                    },
                    no: function () {

                    }
                }
            });

        });

    });
</script>


</body>
<!-- Mirrored from ngetemplates.com/mshop/mshop/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2020 04:46:31 GMT -->
</html>