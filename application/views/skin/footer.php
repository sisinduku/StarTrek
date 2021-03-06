	</div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url("/assets/bower_components/jquery/dist/jquery.min.js");?>"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url("/assets/bower_components/bootstrap/dist/js/bootstrap.min.js");?>"></script>

    <!-- DataTables Core JavaScript -->
    <script src="<?php echo base_url("/assets/js/jquery.dataTables.min.js");?>"></script>
	
	<!-- DataTables Styling JavaScript -->
    <script src="<?php echo base_url("/assets/js/dataTables.bootstrap.js");?>"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url("/assets/bower_components/metisMenu/dist/metisMenu.min.js");?>"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url("/assets/dist/js/sb-admin-2.js");?>"></script>
    
    <?php if (!empty($useTables)) {?>
		<script src="<?php echo base_url('/assets/js/dataTables.js'); ?>"></script>
	<?php }?>
	
	 <?php if (!empty($useTablesUV)) {?>
		<script src="<?php echo base_url('/assets/js/dataTablesUV.js'); ?>"></script>
	<?php }?>
	
	<script>
	$(document).ready( function () {
	   if (typeof(init_page)==='function') {
		   init_page();
	   };
	} );
	</script>
	
	</body>
</html>