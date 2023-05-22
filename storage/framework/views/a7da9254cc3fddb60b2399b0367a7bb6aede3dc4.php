<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if(auth()->user()->pictures()->count() > 0): ?>
            <img src="<?php echo e(route('hrd.employee.profile.get', auth()->user()->pictures()->first()->filename)); ?>" class="img-circle" alt="User Image">
          <?php else: ?>
            <img src="/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          <?php endif; ?>
        </div>
        <div class="pull-left info">
          <p><?php echo e(auth()->user()->name); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?php echo e(auth()->user()->roles()->first()->name); ?></a>
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
        <?php /* <li class="header">Administrator</li> */ ?>
        <li class="treeview <?php echo e(set_active(['admin.user.user.index','admin.user.role.index','admin.user.permission.index'])); ?>">
          
          <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('user.open')): ?>
          <a href="#">
            <i class="fa fa-users fa-lg"></i> <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php endif; ?>
          <ul class="treeview-menu">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('user.open')): ?>
            <li class="<?php echo e(set_active('admin.user.user.index')); ?>"><a href="<?php echo e(route('admin.user.user.index')); ?>"><i class="fa fa-shopping-bag fa-lg" aria-hidden="true"></i>Index</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('role.open')): ?>
            <li class="<?php echo e(set_active('admin.user.role.index')); ?>"><a href="<?php echo e(route('admin.user.role.index')); ?>"><i class="fa fa-circle-o fa-lg" aria-hidden="true"></i>Role</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('permission.open')): ?>
            <li class="<?php echo e(set_active('admin.user.permission.index')); ?>"><a href="<?php echo e(route('admin.user.permission.index')); ?>"><i class="fa fa-circle-o fa-lg" aria-hidden="true"></i>Permission</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('role.super')): ?>
            <li class="<?php echo e(set_active('admin.user.role.setting.get')); ?>"><a href="<?php echo e(route('admin.user.role.setting.get')); ?>"><i class="fa fa-circle-o fa-lg" aria-hidden="true"></i>Settings</a></li>
            <?php endif; ?>
          </ul>
        </li>

        <li class="treeview <?php echo e(set_active(['memo..index','memo.inbox.index','memo.setting.index','memo.approval.index','memo.sent.index','memo.report.index', 'memo.transaction.index', 'supplier.index'])); ?>">
          <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('memo.open')): ?>          
          <a href="#">
            <i class="fa fa-bookmark fa-lg" aria-hidden="true"></i> <span>Memo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php endif; ?>
          <ul class="treeview-menu">
            <li class="<?php echo e(set_active('memo..index')); ?>"><a href="<?php echo e(route('memo..index')); ?>"><i class="fa fa-circle-o fa-lg"></i> Memo</a></li>
            <li class="<?php echo e(set_active('memo.prepayment.index')); ?>"><a href="<?php echo e(route('memo.prepayment.index')); ?>"><i class="fa fa-circle-o fa-lg"></i> Prepayment</a></li>
            <li class="<?php echo e(set_active('memo.inbox.index')); ?>"><a href="<?php echo e(route('memo.inbox.index')); ?>"><i class="fa fa-circle-o fa-lg"></i> Inbox<span class="pull-right-container">
              <span class="label label-danger pull-right" id="memo-inbox-sidebar-count">0</span>
            </span></a></li>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('memo.super')): ?>
            <li class="<?php echo e(set_active('memo.setting.index')); ?>"><a href="<?php echo e(route('memo.setting.index')); ?>"><i class="fa fa-circle-o fa-lg"></i> Setting</a></li>
            <li class="<?php echo e(set_active('memo.approval.index')); ?>"><a href="<?php echo e(route('memo.approval.index')); ?>"><i class="fa fa-circle-o fa-lg"></i> Approval</a></li>
            <?php endif; ?>
            <li class="<?php echo e(set_active('memo.sent.index')); ?>"><a href="<?php echo e(route('memo.sent.index')); ?>"><i 
            class="fa fa-circle-o fa-lg"></i> Log</a></li>
            <li class="<?php echo e(set_active('memo.transaction.index')); ?>"><a href="<?php echo e(route('memo.transaction.index')); ?>"><i 
            class="fa fa-circle-o fa-lg"></i> Budget</a></li>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('memo.super')): ?>
            <li class="<?php echo e(set_active('memo.report.index')); ?>"><a href="<?php echo e(route('memo.report.index')); ?>"><i 
            class="fa fa-circle-o fa-lg"></i> Report</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('memo.super')): ?>
            <li class="<?php echo e(set_active('supplier.index')); ?>"><a href="<?php echo e(route('supplier.index')); ?>"><i 
            class="fa fa-circle-o fa-lg"></i> Supplier</a></li>
            <?php endif; ?>
          </ul>
        </li>

        <li class="treeview <?php echo e(set_active(['marketing.report.get','marketing.vehicle.sales.index','marketing.team.index'])); ?>">
          <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('marketing.open')): ?>
          <a href="#">
            <i class="fa fa-desktop fa-lg" aria-hidden="true" ></i> <span>Marketing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php endif; ?>
          <ul class="treeview-menu">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('marketing.vehicle.sales.open')): ?>
            <li class="<?php echo e(set_active('marketing.vehicle.sales.index')); ?>"><a href="<?php echo e(route('marketing.vehicle.sales.index')); ?>"><i class="fa fa-barcode" aria-hidden="true"></i> Vehicle Sales</a></li>  
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('marketing.report.open')): ?>
            <li class="<?php echo e(set_active('marketing.report.get')); ?>"><a href="<?php echo e(route('marketing.report.get')); ?>"><i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i> Daily Report</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('marketing.report.open')): ?>
            <li class="<?php echo e(set_active('marketing.report.sales.get')); ?>"><a href="<?php echo e(route('marketing.report.sales.get')); ?>"><i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i> Daily Report by Sales</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('marketing.team.open')): ?>
              <li class="<?php echo e(set_active('marketing.team.index')); ?>">
              <a href="<?php echo e(route('marketing.team.index')); ?>">
                <i class="fa fa-child fa-lg" aria-hidden="true"></i> Team Marketing
              </a>
            </li>
            <?php endif; ?>
            <li class="<?php echo e(set_active('marketing.agenda.index')); ?>">
              <a href="<?php echo e(route('marketing.agenda.index')); ?>">
                <i class="fa fa-child fa-lg" aria-hidden="true"></i> Agenda
              </a>
            </li>
          </ul>
        </li>
        
        <li class="treeview <?php echo e(set_active(['hrd.employee.index', 'hrd.department.index', 'hrd.position.index'])); ?>">
          <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('hrd.employee.open')): ?>
          <a href="#">
            <i class="fa fa-user-secret fa-lg" aria-hidden="true"></i> <span>HRD</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php endif; ?>
          <ul class="treeview-menu">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('hrd.employee.open')): ?>
            <li class="<?php echo e(set_active('hrd.employee.index')); ?>"><a href="<?php echo e(route('hrd.employee.index')); ?>"><i class="fa fa-dot-circle-o fa-lg" aria-hidden="true"></i></i>Employee</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('hrd.department.open')): ?>
            <li class="<?php echo e(set_active('hrd.department.index')); ?>"><a href="<?php echo e(route('hrd.department.index')); ?>"><i class="fa fa-cubes fa-lg" aria-hidden="true"></i></i>Department</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('hrd.position.open')): ?>
            <li class="<?php echo e(set_active('hrd.position.index')); ?>"><a href="<?php echo e(route('hrd.position.index')); ?>"><i class="fa fa-dot-circle-o fa-lg" aria-hidden="true"></i></i>Position</a></li>
            <?php endif; ?>
          </ul>
        </li>
        
        <li class="treeview <?php echo e(set_active(['upload.sales.get','upload.hr.get'])); ?>">
          <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('upload.open')): ?>          
          <a href="#">
            <i class="fa fa-cloud-upload fa-lg"></i> <span>Upload</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php endif; ?>
          <ul class="treeview-menu">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('upload.sales')): ?>            
            <li class="<?php echo e(set_active('upload.sales.get')); ?>"><a href="<?php echo e(route('upload.sales.get')); ?>"><i class="fa fa-circle-o fa-lg"></i> Upload Sales</a></li>
            <?php endif; ?>
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('upload.hrd')): ?>            
            <li class="<?php echo e(set_active('upload.hr.get')); ?>"><a href="<?php echo e(route('upload.hr.get')); ?>"><i class="fa fa-circle-o fa-lg"></i> Upload HR</a></li>
            <?php endif; ?>
          </ul>
        </li>

        <li class="treeview <?php echo e(set_active(['crm.index'])); ?>">
          <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('crm.open')): ?>
          <a href="<?php echo e(route('crm.index')); ?>">
            <i class="fa fa-database fa-lg"></i><span>Customer</span>
          </a>
          <?php endif; ?>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>