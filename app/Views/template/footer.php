<?php ?>
    </div>
    </div>
    <script src="<?php echo base_url('public/assets/libs/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('public/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo base_url('public/assets/js/sidebarmenu.js');?>"></script>
    <script src="<?php echo base_url('public/assets/js/app.min.js');?>"></script>
    <script src="<?php echo base_url('public/assets/libs/simplebar/dist/simplebar.js')?>"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <!-- <script src="<?php echo base_url('public/assets/js/jquery-3.7.1.js')?>"></script>
    <script src="<?php echo base_url('public/assets/js/jquery-ui.js')?>"></script> -->
    <script>
        window.SvcaConfig = {
            baseUrl: '<?php echo base_url(); ?>'
        };
        window.SvcaViewInit = '<?php echo isset($app_init) ? $app_init : ""; ?>';
    </script>
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/moment-2.29.4/dt-2.3.2/sl-3.0.1/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="<?php echo base_url('public/assets/js/script.js');?>"></script>
</body>
</html>