<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../template_assets/global/plugins/respond.min.js"></script>
<script src="../../template_assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="{{asset('template_assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{asset('template_assets/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/global/plugins/select2/select2.min.js')}}"></script>
<!-- END CORE PLUGINS -->
<script src="{{asset('template_assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/admin/layout4/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{asset('template_assets/admin/layout4/scripts/demo.js')}}" type="text/javascript"></script>
{{-- tinymce text editor js --}}
<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>
{{-- <script src="{{asset('template_assets/admin/pages/scripts/components-editors.js')}}"></script> --}}
{{-- <script src="{{asset('template_assets/global/plugins/bootstrap-summernote/summernote.min.js')}}"></script>
<script src="{{asset('template_assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
<script src="{{asset('template_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script> --}}

{{-- end text editor --}}
{{-- yajrabox scripts --}}
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.bootstrap.js')}}"></script>

<script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.server-side.js')}}"></script>

<script src="{{asset('assets/js/persianDatepicker.js')}}"></script>
{{-- portfolio scripts --}}
<script src="{{asset('template_assets/admin/pages/scripts/portfolio.js')}}"></script>
<script type="text/javascript" src="{{asset('template_assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}"></script>
{{-- script fro scanning --}}
{{-- <script src="{{asset('assets/js/scanner.js')}}" type="text/javascript"></script> --}}
{{-- end --}}

{{--Farsi type for switching language --}}
<script language="javascript" src="{{asset('assets/js/FarsiType.js')}}" type="text/javascript"></script>

{{-- alert scripts --}}
<script type="text/javascript" src="{{asset('template_assets/global/plugins/bootbox/bootbox.min.js')}}"></script>
<script type="text/javascript" src="{{asset('template_assets/admin/pages/scripts/ui-alert-dialog-api.js')}}"></script>
{{-- chart scripts --}}
{{-- <script type="text/javascript" src="{{asset('template_assets/admin/pages/scripts/charts-flotcharts.js')}}"></script> --}}

{{-- <script src="/local/vendor/datatables/buttons.server-side.js"></script> --}}
{{-- laravel charts assets --}}
{{-- <script src=//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js charset=utf-8></script> --}}
<script src="{{asset('assets/js/Chart.min.js')}}"></script>
{{-- <script src=//cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js charset=utf-8></script> --}}
{{-- date changer to three type date --}}
<scriptsrc="{{asset('assets/test/astro.js')}}"></script>


<script>

      jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Demo.init(); // init demo features
        // ComponentsEditors.init();
        tinymce.init({ selector:'.tinymce' });

        $('.select2-multiple').select2();

        $(".select2-multiple").select2({
            placeholder: "کشورها",
            allowClear: true
        });

        $('.select2').select2();//select2 searchable dropdown
         // persian date picker
        $(".persian_date").persianDatepicker();
        // $(function() {
        // });
      });

      //script for buttons tooltips
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
      });

      //function to continuosly fetch unread notifications count
      $(function () {

        function fetchUnreadNotificationsCount() {
          $.ajax({
            type:'get',
            url:"{{url('get_unread_notifications_count')}}",
            success: function(res) {
              $('.notifications_count').html(res);
            }

          }).then(function() {           // on completion, restart
            setTimeout(fetchUnreadNotificationsCount, 10000);  // function refers to itself
          });
        };

        fetchUnreadNotificationsCount();

      });

      //function to get notifications on hover
      $('#notification_button').click(function() {
        $.ajax({
          type: 'get',
          url: "{{url('get_unread_notifications')}}",
          beforeSend: function() {
            $('#unread_notifications').html('<img style="width: 20px;display: block;margin: 10px auto;" src="{{asset('assets/images/loading.gif')}}">');
          },
          success: function(res) {
            $('#unread_notifications').html(res);
          }

        })
      });

      //function for marking a notification as true
      //notification table : document_id = data->document_id
      function markAsRead(notification_id, document_id='', type='') {
        console.log(notification_id);
        $.ajax({
          type: 'get',
          url: "{{url('mark_as_read')}}/"+notification_id,
          success: function() {
            if(type=='document') {
              document.location.href="{{url('edit_rejected_document')}}/"+document_id;
            }
            else if(type=='enquiry') {
              document.location.href="{{url('show_all_enquiries')}}";
            }
            else if(type=='stock') {
              document.location.href="{{url('edit_stock')}}/"+document_id;
            }
            else if(type=='admin') {
              document.location.href="{{url('show_stock_edit_request')}}/"+document_id;
            }

          }

        })
      }



  </script>

<!-- END JAVASCRIPTS -->
