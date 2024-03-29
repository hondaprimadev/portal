<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if (auth()->user()->pictures()->count() > 0)
            <img src="{{ route('hrd.employee.profile.get', auth()->user()->pictures()->first()->filename) }}" class="img-circle" alt="User Image">
          @else
            <img src="/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          @endif
        </div>
        <div class="pull-left info">
          <p>{{ auth()->user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{ auth()->user()->roles()->first()->name }}</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li><a href="/"><i class="fa fa-dashcube fa-lg"></i><span>Dashboard</span></a></li>
        {{-- <li class="header">Administrator</li> --}}
        <li class="treeview {{ set_active(['admin.user.user.index','admin.user.role.index','admin.user.permission.index']) }}">
          
          @can('user.open')
          <a href="#">
            <i class="fa fa-users fa-lg"></i> <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          @endcan
          <ul class="treeview-menu">
            @can('user.open')
            <li class="{{ set_active('admin.user.user.index') }}"><a href="{{ route('admin.user.user.index') }}"><i class="fa fa-shopping-bag fa-lg" aria-hidden="true"></i>Index</a></li>
            @endcan
            @can('role.open')
            <li class="{{ set_active('admin.user.role.index') }}"><a href="{{ route('admin.user.role.index') }}"><i class="fa fa-circle-o fa-lg" aria-hidden="true"></i>Role</a></li>
            @endcan
            @can('permission.open')
            <li class="{{ set_active('admin.user.permission.index') }}"><a href="{{ route('admin.user.permission.index') }}"><i class="fa fa-circle-o fa-lg" aria-hidden="true"></i>Permission</a></li>
            @endcan
            @can('role.super')
            <li class="{{ set_active('admin.user.role.setting.get') }}"><a href="{{ route('admin.user.role.setting.get') }}"><i class="fa fa-circle-o fa-lg" aria-hidden="true"></i>Settings</a></li>
            @endcan
          </ul>
        </li>

        <li class="treeview {{ set_active(['memo..index','memo.inbox.index','memo.setting.index','memo.approval.index','memo.sent.index','memo.report.index', 'memo.transaction.index', 'supplier.index']) }}">
          @can('memo.open')          
          <a href="#">
            <i class="fa fa-bookmark fa-lg" aria-hidden="true"></i> <span>Memo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          @endcan
          <ul class="treeview-menu">
            <li class="{{ set_active('memo..index') }}"><a href="{{ route('memo..index') }}"><i class="fa fa-circle-o fa-lg"></i> Memo</a></li>
            <li class="{{ set_active('memo.prepayment.index') }}"><a href="{{ route('memo.prepayment.index') }}"><i class="fa fa-circle-o fa-lg"></i> Prepayment</a></li>
            <li class="{{ set_active('memo.inbox.index') }}"><a href="{{ route('memo.inbox.index') }}"><i class="fa fa-circle-o fa-lg"></i> Inbox<span class="pull-right-container">
              <span class="label label-danger pull-right" id="memo-inbox-sidebar-count">0</span>
            </span></a></li>
            @can('memo.super')
            <li class="{{ set_active('memo.setting.index') }}"><a href="{{ route('memo.setting.index') }}"><i class="fa fa-circle-o fa-lg"></i> Setting</a></li>
            <li class="{{ set_active('memo.approval.index') }}"><a href="{{ route('memo.approval.index') }}"><i class="fa fa-circle-o fa-lg"></i> Approval</a></li>
            @endcan
            <li class="{{ set_active('memo.sent.index') }}"><a href="{{ route('memo.sent.index') }}"><i 
            class="fa fa-circle-o fa-lg"></i> Log</a></li>
            <li class="{{ set_active('memo.transaction.index') }}"><a href="{{ route('memo.transaction.index') }}"><i 
            class="fa fa-circle-o fa-lg"></i> Budget</a></li>
            @can('memo.super')
            <li class="{{ set_active('memo.report.index') }}"><a href="{{ route('memo.report.index') }}"><i 
            class="fa fa-circle-o fa-lg"></i> Report</a></li>
            @endcan
            @can('memo.super')
            <li class="{{ set_active('supplier.index') }}"><a href="{{ route('supplier.index') }}"><i 
            class="fa fa-circle-o fa-lg"></i> Supplier</a></li>
            @endcan
          </ul>
        </li>

        <li class="treeview {{ set_active(['marketing.report.get','marketing.vehicle.sales.index','marketing.team.index']) }}">
          @can('marketing.open')
          <a href="#">
            <i class="fa fa-desktop fa-lg" aria-hidden="true" ></i> <span>Marketing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          @endcan
          <ul class="treeview-menu">
            @can('marketing.vehicle.sales.open')
            <li class="{{ set_active('marketing.vehicle.sales.index') }}"><a href="{{ route('marketing.vehicle.sales.index') }}"><i class="fa fa-barcode" aria-hidden="true"></i> Vehicle Sales</a></li>  
            @endcan
            @can('marketing.report.open')
            <li class="{{ set_active('marketing.report.get') }}"><a href="{{ route('marketing.report.get') }}"><i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i> Daily Report</a></li>
            @endcan
            @can('marketing.report.open')
            <li class="{{ set_active('marketing.report.sales.get') }}"><a href="{{ route('marketing.report.sales.get') }}"><i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i> Daily Report by Sales</a></li>
            @endcan
            @can('marketing.team.open')
              <li class="{{ set_active('marketing.team.index') }}">
              <a href="{{ route('marketing.team.index') }}">
                <i class="fa fa-child fa-lg" aria-hidden="true"></i> Team Marketing
              </a>
            </li>
            @endcan
            <li class="{{ set_active('marketing.agenda.index') }}">
              <a href="{{ route('marketing.agenda.index') }}">
                <i class="fa fa-child fa-lg" aria-hidden="true"></i> Agenda
              </a>
            </li>
          </ul>
        </li>
        
        <li class="treeview {{ set_active(['hrd.employee.index', 'hrd.department.index', 'hrd.position.index']) }}">
          @can('hrd.employee.open')
          <a href="#">
            <i class="fa fa-user-secret fa-lg" aria-hidden="true"></i> <span>HRD</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          @endcan
          <ul class="treeview-menu">
            @can('hrd.employee.open')
            <li class="{{ set_active('hrd.employee.index') }}"><a href="{{ route('hrd.employee.index') }}"><i class="fa fa-dot-circle-o fa-lg" aria-hidden="true"></i></i>Employee</a></li>
            @endcan
            @can('hrd.department.open')
            <li class="{{ set_active('hrd.department.index') }}"><a href="{{ route('hrd.department.index') }}"><i class="fa fa-cubes fa-lg" aria-hidden="true"></i></i>Department</a></li>
            @endcan
            @can('hrd.position.open')
            <li class="{{ set_active('hrd.position.index') }}"><a href="{{ route('hrd.position.index') }}"><i class="fa fa-dot-circle-o fa-lg" aria-hidden="true"></i></i>Position</a></li>
            @endcan
          </ul>
        </li>
        
        <li class="treeview {{ set_active(['upload.sales.get','upload.hr.get']) }}">
          @can('upload.open')          
          <a href="#">
            <i class="fa fa-cloud-upload fa-lg"></i> <span>Upload</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          @endcan
          <ul class="treeview-menu">
            @can('upload.sales')            
            <li class="{{ set_active('upload.sales.get') }}"><a href="{{ route('upload.sales.get') }}"><i class="fa fa-circle-o fa-lg"></i> Upload Sales</a></li>
            @endcan
            @can('upload.hrd')            
            <li class="{{ set_active('upload.hr.get') }}"><a href="{{ route('upload.hr.get') }}"><i class="fa fa-circle-o fa-lg"></i> Upload HR</a></li>
            @endcan
          </ul>
        </li>

        <li class="treeview {{ set_active(['crm.index']) }}">
          @can('crm.open')
          <a href="{{ route('crm.index') }}">
            <i class="fa fa-database fa-lg"></i><span>Customer</span>
          </a>
          @endcan
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>