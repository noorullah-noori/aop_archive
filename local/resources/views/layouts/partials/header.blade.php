<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
		    <a href="{!! route('dashboard') !!}">
		    <img src="{{asset('assets/images/logo_2.png')}}" alt="logo" class="logo-default">
		    </a>
		    <div class="menu-toggler sidebar-toggler">
		        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
		    </div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->

		<!-- BEGIN PAGE TOP -->
		<div class="page-top">

			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<li class="separator hide">
					</li>
					<!-- BEGIN NOTIFICATION DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					@hasrole('approval')
					<!-- dont show notifications to approval user(s)-->
					@else
					<li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
						<a href="javascript:;" id="notification_button" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
						<i class="icon-bell" id=""></i>
						<span class="badge badge-danger notifications_count"></span>
						</a>
						<ul class="dropdown-menu rtl">
						  <li class="external">
						    <h3><span class="bold notifications_count"></span> اطلاعیه جدید</h3>
						    <a href="{{route('all_notifications')}}">نمایش همه</a>
						  </li>
						  <li id="unread_notifications">

						  </li>
						</ul>
					</li>
					@endhasrole
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- END TODO DROPDOWN -->

					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
						<span class="username username-hide-on-mobile">
						{{Auth::user()!=null ? Auth::user()->name : ''}} </span>
						<!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
						<img alt="" class="img-circle" src="{{asset('assets/images/login_avatar1.png')}}"/>
						</a>
						<ul class="dropdown-menu dropdown-menu-default rtl">
						@if(!Auth::guest())
							<li>
								<a class="persian_font" href="{{ route('users.edit',Auth::user()->id) }}">
								<i class="icon-key"></i>
										تغیر رمز
								</a>
							</li>
						@endif
							<li>
								<a class="persian_font" href="{{ route('logout') }}"
										 onclick="event.preventDefault();
															document.getElementById('logout-form').submit();">
								 <i class="fa fa-power-off"></i>
								 خروج </a>

								 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										 {{ csrf_field() }}
								 </form>
							</li>

						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
