 <!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
      <li class="{{Request::is('/')?'active':''}} start">
        <a href="{{route('dashboard')}}">
        <i class="icon-home"></i>
        <span class="title">صفحه اصلی</span>
        </a>
      </li>


      @hasrole('entry')
        <li class="{{(Request::is('documents/create') || Request::is('documents_approval') || Request::is('stock_documents')|| Request::is('stockable_documents')|| Request::is('stockable_documents/success'))?'active':''}} ">
          <a href="javascript:;">
          <i class="icon-doc"></i>
          <span class="title">عملیات اسناد</span>
          <span class="arrow "></span>
          </a>
          <ul class="sub-menu" style="{{(Request::is('documents/create') || Request::is('documents_approval') || Request::is('stock_documents')|| Request::is('stockable_documents')|| Request::is('stockable_documents/success'))?'display:block;':''}}">
              @hasanyrole('entry|faramin|ahkam|hedayat_nama_ha|musawebat|qawanin|tarzul_amal_ha|muqarara_ha|asas_nama_ha|muahedat|tafahum_nama_wa_yadasht_tafahum_nama_ha|protocol_ha|misaq_ha|makatib|kutub_e_shahi|asnad_e_melkiat_ha')
                <li class="{{Request::is('documents/create')?'active':''}}" class="">
                  <a href="{{route('documents.create')}}">
                    <i class="icon-plus"></i>
                    ثبت اسناد
                  </a>
                </li>
              @endhasanyrole

              @can('approve_document')
                <li class="{{Request::is('documents_approval')?'active':''}}">
                  <a href="{{route('documents_approval')}}">
                    <i class="icon-eyeglasses"></i>
                    تاییدی اسناد</a>
                </li>
              @endcan

              </li>

            @can('stockable_document')
              <li class="{{Request::is('stockable_documents')||Request::is('stockable_documents/success') ?'active':''}}">
                <a href="{{route('stockable_documents')}}">
                  <i class="icon-drawer"></i>
                  جابجایی اسناد</a>
                </li>
            @endcan
        </ul>
      </li>
      @endhasanyrole

      @hasrole('entry')
        <li class="{{(Request::is('saved_documents') || Request::is('documents')|| Request::is('approved_documents') || Request::is('rejected_documents') || Request::is('show_completed_documents')|| Request::is('show_enquiries_edit_status')) ?'active':''}}">
          <a href="javascript:;">
          <i class="icon-eye"></i>
          <span class="title">نمایش اسناد</span>
          <span class="arrow "></span>
          </a>
          <ul class="sub-menu" style="{{(Request::is('saved_documents') || Request::is('documents') || Request::is('approved_documents') || Request::is('rejected_documents') || Request::is('show_completed_documents')|| Request::is('show_enquiries_edit_status')) ?'display:block;':''}}">
            @can('show_saved_documents')
              <li class="{{Request::is('saved_documents')?'active':''}}" class="">
                <a href="{{route('saved_documents')}}">
                  <i class="icon-docs"></i>
                  اسناد ثبت شده
                  </a>
                </li>
            @endcan

            @can('show_approvable_documents')
              <li class="{{Request::is('approved_documents')?'active':''}}">
                <a href="{{route('approved_documents')}}">
                <i class="icon-check"></i>
                اسناد تایید شده</a>
              </li>
            @endcan

            @can('show_rejected_documents')
              <li class="{{Request::is('rejected_documents')?'active':''}}">
                <a href="{{route('rejected_documents')}}">
                  <i class="icon-close"></i>
                  اسناد رد شده</a>
                </li>
            @endcan
            @can ('show_completed_documents')
              <li class="{{Request::is('show_completed_documents')?'active':''}}">
                <a href="{{route('completed_documents')}}">
                  <i class=" icon-notebook"></i>
                  اسناد تکمیل شده</a>
                </li>
            @endcan
            @can('show_stocked_edit_status')
              <li class="{{Request::is('show_stocked_edit_status')?'active':''}}">
                <a href="{{route('show_stocked_edit_status')}}">
                  <i class="  icon-reload"></i>
                  وضعیت تصحیح جابجایی سند</a>
                </li>
            @endcan
          </ul>
        </li>
      @endhasanyrole
      @hasanyrole('enquiry|admin')
        <li class="{{Request::is('enquiries') || Request::is('show_enquiries')||Request::is('show_all_enquiries') ? 'active' : ''}}">
          <a href="#">
          <i class=" icon-share"></i>
          <span class="title">درخواستی اسناد</span>
          <span class="arrow "></span>
          </a>
          <ul class="sub-menu" style="{{ Request::is('show_all_enquiries') || Request::is('show_enquiries')||Request::is('show_all_enquiries') ?'display:block;':''}}">

            @can ('issue_enquiry')
              <li class="{{Request::is('enquiries') ?'active':''}}">
                <a href="{{route('enquiries.index')}}">
                  <i class="icon-share-alt"></i>
                  درج درخواستی</a>
                </li>
            @endcan

            @can ('edit_enquiry')
              <li class="{{Request::is('enquiries') ?'active':''}}">
                <a href="{{route('edit_enquiries')}}">
                  <i class="icon-share-alt"></i>
                  تصحیح درخواستی ها</a>
                </li>
            @endcan

            @can('show_enquiries')
              <li class="{{Request::is('show_enquiries')?'active':''}}">
                <a href="{{route('show_enquiries')}}">
                  <i class="icon-size-actual"></i>
                  بازگشت اسناد</a>
                </li>
            @endcan

            @can ('show_all_enquiries')
              <li class="{{Request::is('show_all_enquiries')?'active':''}}">
                <a href="{{route('show_all_enquiries')}}">
                  <i class=" icon-eye"></i>
                  درخواستی ها</a>
                </li>
            @endcan
          </ul>
        </li>
      @endhasanyrole
      @hasrole('admin')
        <li class="{{Request::is('stock_edit_requests') ? 'active' : ''}}">
          <a href="#">
          <i class="icon-loop"></i>
          <span class="title">درخواستی های تصحیح</span>
          <span class="arrow "></span>
          </a>
          <ul class="sub-menu" style="{{Request::is('stock_edit_requests') ?'display:block;':''}}">
              <li class="{{Request::is('stock_edit_requests') ?'active':''}}">
                <a href="{{route('stock_edit_requests')}}">
                  <i class="icon-loop"></i>
                  درخواستی جابجایی اسناد</a>
                </li>
          </ul>
        </li>

      <li class="{{Request::is('documents_reports') || Request::is('enquiries_reports') ? 'active':''}}">
        <a href="javascript:;">
        <i class="icon-graph"></i>
        <span class="title" >گزارش ها</span>
        <span class="arrow "></span>
        </a>
        <ul class="sub-menu" style="{{Request::is('documents_reports') || Request::is('enquiries_reports') ? 'display:block;':''}}" >
          <li class="{{Request::is('documents_reports')?'active':''}}">
            <a href="{{route('documents_reports')}}">
            <i class="icon-doc"></i>
            اسناد</a>
          </li>
          <li class="{{Request::is('enquiries_reports')?'active':''}}">
            <a href="{{route('enquiries_reports')}}">
            <i class="icon-key"></i>
            درخواستی ها</a>
          </li>
        </ul>
      </li>
      <li class="{{(Request::is('categories') || Request::is('departments') || Request::is('users') || Request::is('roles') || Request::is('permissions')|| Request::is('document_language') || Request::is('show_language_form') || Request::is('notice')) ?'active':'' }}">
        <a href="javascript:;">
        <i class="icon-settings"></i>
        <span class="title">تنظیمات</span>
        <span class="arrow "></span>
        </a>
        <ul class="sub-menu" style="{{(Request::is('categories') || Request::is('departments')) || Request::is('users') || Request::is('roles') || Request::is('permissions')  || Request::is('document_language') || Request::is('show_language_form') || Request::is('notice')?'display:block;':''}}">
          <li class="{{Request::is('departments')?'active':''}}">
            <a href="{{route('departments.index')}}">
            <i class="icon-loop"></i>
            مراجع</a>
          </li>
          <li class="{{Request::is('categories')?'active':''}}">
            <a href="{{route('categories.index')}}">
            <i class=" icon-tag"></i>
            نوعیت اسناد</a>
          </li>
          <li class="{{Request::is('document_language')|| Request::is('show_language_form')  ?'active':''}}">
            <a href="{{route('document_language')}}">
            <i class=" icon-tag"></i>
            لسان سند</a>
          </li>

          <li class="{{Request::is('notice')?'active':''}}">
            <a href="{{route('notice.index')}}">
            <i class="icon-speech"></i>
                اطلاعیه ها</a>
          </li>

          <li class="{{Request::is('view_logs')?'active':''}}">
            <a href="{{route('view_logs')}}">
            <i class="icon-speech"></i>
                تاریخچه</a>
          </li>



          <li class="{{Request::is('users') || Request::is('roles') || Request::is('permissions') ?'active':''}}">
            <a href="javascript:;">
              <i class="icon-settings"></i> تنظیمات کاربران <span class="arrow"></span>
            </a>
            <ul class="sub-menu" style="{{Request::is('users') || Request::is('roles') || Request::is('permissions') ?'display:block;':''}}">

              <li class="{{Request::is('users')?'active':''}}">
                <a href="{{route('users.index')}}">
                <i class="icon-user"></i>
                کاربران</a>
              </li>
              <li class="{{Request::is('roles')?'active':''}}">
                <a href="{{route('roles.index')}}">
                <i class="icon-user"></i>
                نقش ها</a>
              </li>
              <li class="{{Request::is('permissions')?'active':''}}">
                <a href="{{route('permissions.index')}}">
                <i class="icon-key"></i>
                صلاحیت ها</a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      @endhasrole


    </ul>
    <!-- END SIDEBAR MENU -->
  </div>
</div>
<!-- END SIDEBAR -->
