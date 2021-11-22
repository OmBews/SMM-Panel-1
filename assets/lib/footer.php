</div>
</div>
  <footer class="footer text-right">
		<div class="container">
			<div class="row">
	<div class="col-xs-12 text-center">
		&copy; 2021 <b>Dimas SMM Panel</b>
                            </div>
    </footer>


</div>
<!-- ./wrapper -->

<!-- jQuery  -->
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/detect.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/fastclick.js"></script>

        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/waves.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/wow.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.scrollTo.min.js"></script>

        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="assets/plugins/jquery-knob/excanvas.js"></script>
        <![endif]-->
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/jquery-knob/jquery.knob.js"></script>

        <!--Morris Chart-->
		<script src="<?php echo $cfg_baseurl; ?>assets/plugins/morris/morris.min.js"></script>
		<script src="<?php echo $cfg_baseurl; ?>assets/plugins/raphael/raphael-min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/pages/jquery.morris.init.js"></script>
        <!-- Dashboard init -->
        <script src="<?php echo $cfg_baseurl; ?>assets/pages/jquery.dashboard.js"></script>

        <!-- App js -->
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/js/jquery.app.js"></script>
        
        <!-- Datatables-->
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/jszip.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo $cfg_baseurl; ?>assets/plugins/datatables/dataTables.scroller.min.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
                $('#datatable-keytable').DataTable( { keys: true } );
                $('#datatable-responsive').DataTable();
                $('#datatable-scroller').DataTable( { ajax: "../assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
                var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
            } );
            TableManageButtons.init();

        </script>
        
<script type="text/javascript">
    $(document).ready(function(){
        $("#category").change(function(){
            var category = $("#category").val();
            $.ajax({
                url : '<?php echo $cfg_baseurl; ?>inc/order_service.php',
                data  : 'category='+category,
                type  : 'POST',
                dataType: 'html',
                success : function(msg){
                    $("#service").html(msg);
                }
            });
        });
        $("#service").change(function(){
            var service = $("#service").val();
            $.ajax({
                url : '<?php echo $cfg_baseurl; ?>inc/order_note.php',
                data  : 'service='+service,
                type  : 'POST',
                dataType: 'html',
                success : function(msg){
                    $("#note").html(msg);
                }
            });
            $.ajax({
                url : '<?php echo $cfg_baseurl; ?>inc/order_rate.php',
                data  : 'service='+service,
                type  : 'POST',
                dataType: 'html',
                success : function(msg){
                    $("#rate").val(msg);
                }
            });
        });
    });
    function get_total(quantity) {
        var rate = $("#rate").val();
        var result = eval(quantity) * rate;
        $('#total').val(result);
    }
    </script>
<script type="text/javascript"> 
var htmlobjek; 
$(document).ready(function(){ 

  $("#level").change(function(){ 
    var level = $("#level").val(); 

    $.ajax({ 
        url    : '../inc/note_adduser.php', 
        data    : 'level='+level, 
        type    : 'POST', 
        dataType: 'html', 
        success    : function(msg){ 
                 $("#note").html(msg); 
            } 
    }); 
  }); 
}); 
</script>
	</body>

</html>