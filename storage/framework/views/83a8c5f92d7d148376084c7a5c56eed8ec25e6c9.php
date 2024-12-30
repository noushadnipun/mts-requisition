<nav class="navbar o_main_navbar is-navbar-bg is-link is-fixed-top" role="navigation" aria-label="dropdown navigation">
    <div class="navbar-brand">
        <a href="<?php echo e(url('dashboard')); ?>" class="navbar-item">
            <span class="navbar-item" class="o_menu_brand" href="javascript:void(0)">
                <img src="<?php echo e(asset('public/images/mtsbd.png')); ?>"/>
            </span>
            
        </a>


        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
           data-target="navbarExampleTransparentExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navbarExampleTransparentExample" class="navbar-menu">

        <div class="navbar-start">
            <?php echo $__env->yieldContent('header_title_set'); ?>
            <?php $routelist = \App\Models\Routelist::where('show_menu', '=', 1)->where('is_active', '=', 1)->get(); ?>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="javascript:void(0)">
                    <i class="fas fa-bars"></i>&nbsp; Quick links
                </a>

                <div class="navbar-dropdown">
                    <?php $__currentLoopData = $routelist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $selected = explode(",", $menu->to_role);
                        ?>
                        <?php if(!empty(Auth::user()->role)): ?>
                            <?php if(in_array(Auth::user()->role, $selected)): ?>
                                <?php if($menu->route_url == '#' || $menu->route_url == NULL): ?>
                                    <?php $link = '#'; ?>
                                <?php else: ?>
                                    <?php $link = route($menu->route_url) . '?route_id=' . $menu->id; ?>
                                <?php endif; ?>
                                <a href="<?php echo e($link ?? NULL); ?>"
                                   class="navbar-item">
                                    <i class="<?php echo e($menu->font_awesome ?? NULL); ?>"></i>&nbsp; <?php echo e($menu->route_name); ?>

                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('hidtory.user',  auth()->user()->id)); ?>"
                       class="navbar-item">
                        <i class="<?php echo e($menu->font_awesome ?? NULL); ?>"></i>&nbsp; Resource Summary
                    </a>
                  <?php /*
                    @if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isManager(auth()->user()->id) || auth()->user()->isCFO(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)  || auth()->user()->isHR(auth()->user()->id))
                        <a href="{{ route('live.resource.usage') }}"
                           class="navbar-item">
                            <i class="fas fa-stream"></i>&nbsp;&nbsp;Live resource Usage
                        </a>

                        <a href="{{ route('archive.resource.usage') }}"
                           class="navbar-item">
                            <i class="fas fa-stream"></i>&nbsp;&nbsp; Resource Usage Archive
                        </a>
                    @endif
                   
                    @if(auth()->user()->isAdmin(auth()->user()->id) ||  auth()->user()->isAccountant(auth()->user()->id) || auth()->user()->isCFO(auth()->user()->id))
                    	 <a href="{{ route('archive.resource.transaction') }}"
                           class="navbar-item">
                            <i class="fas fa-stream"></i>&nbsp;&nbsp; Resource Transaction Archive
                        </a>
                    @endif
				 */ ?>
                  <?php /*
                    @if(auth()->user()->isAccountant(auth()->user()->id))
                        <a href="{{ route('excel.requisition.report.accountant') }}"
                           class="navbar-item">
                            <i class="fas fa-stream"></i>&nbsp;&nbsp;Requisition Report
                        </a>
                        <a href="{{ route('excel.bill.report.accountant') }}"
                           class="navbar-item">
                            <i class="fas fa-stream"></i>&nbsp;&nbsp;Bill Report
                        </a>
                        <a href="{{ route('excel.site.report.accountant') }}"
                           class="navbar-item">
                            <i class="fas fa-stream"></i>&nbsp;&nbsp;Sites Invoice Report
                        </a>

                        <a href="{{ route('projects.add.mobile.bill') }}"
                           class="navbar-item">
                            <i class="fas fa-stream"></i>&nbsp;&nbsp;Add Mobile Bill
                        </a>
                    @endif
                   

                    @if(auth()->user()->isAccountant(auth()->user()->id) || auth()->user()->isManager(auth()->user()->id))
                            <a href="{{ route('multiple.site.invoice') }}"
                               class="navbar-item">
                                <i class="fas fa-file-invoice"></i>&nbsp;&nbsp;Invoice Generate
                            </a>
                    @endif
                  
                  
                   @if(auth()->user()->isCFO(auth()->user()->id))
                            <a href="{{ route('excel.manager.site.report') }}"
                               class="navbar-item">
                                <i class="fas fa-file-invoice"></i>&nbsp;&nbsp;Site Report of Manager
                            </a>
                    @endif
                   */ ?>

                </div>
            </div>
        </div>


        <?php echo $__env->yieldContent('header_button_set'); ?>

        <?php
        $rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', 1);
        ?>

        <div class="navbar-end">
            <?php /*
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">Transaction Summary</a>
                    <div class="navbar-dropdown has-text-black">
                        <div class="transaction_summary">
                            <table class="table is-bordered">
                                <tr>
                                    <td>Total Approved Requisition</td>
                                    <td>
                                        <?php
                                            echo $rm->getTotal();
                                            echo '<br/>';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Approved Bill</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Fraction</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            */ ?>
            <div class="navbar-item has-dropdown is-hoverable">
                <?php $current_user = auth()->user(); //dump($current_user)?>
                <a class="navbar-link">
                    <figure class="image is-32x32" style="margin-right: 5px;">
                        <img class="is-rounded" src="<?php echo e(asset('/')); ?>/<?php echo e(auth()->user()->avatar); ?>" alt="">
                    </figure>
                    Welcome, <strong style="color: yellow"> &nbsp;<?php echo e(@$current_user->name); ?> &nbsp;</strong>
                    as <?php echo e(\App\Models\Role::where('id', $current_user->role)->first()->name); ?>

                </a>
                <div class="navbar-dropdown is-right">
                    <?php if(auth()->user()->isAdmin(auth()->user()->id)): ?>
                        <a class="navbar-item" href="<?php echo e(route('settings.global', 1)); ?>">
                            <i class="fas fa-wrench"></i>&nbsp;Global Settings
                        </a>
                        <a class="navbar-item" href="<?php echo e(route('settings.payment', 2)); ?>">
                            <i class="fas fa-dollar-sign"></i>&nbsp;Payment Settings
                        </a>
                        <a class="navbar-item" href="<?php echo e(route('settings.time', 3)); ?>">
                            <i class="fas fa-clock"></i>&nbsp;Time Settings
                        </a>
                        <a class="navbar-item" href="<?php echo e(route('settings.email', 4)); ?>">
                            <i class="fas fa-envelope"></i>&nbsp;Email Settings
                        </a>
                        <a class="navbar-item" href="<?php echo e(route('settings.other', 5)); ?>">
                            <i class="fas fa-cog"></i>&nbsp;Other Settings
                        </a>
                        <a href="<?php echo e(url('routelists')); ?>" class="navbar-item">
                            <i class="fas fa-link"></i>&nbsp;Route Lists
                        </a>
                        <hr class="navbar-divider">
                    <?php endif; ?>
                    <div class="navbar-item">
                        <i class="fas fa-key"></i>&nbsp;
                        <a href="<?php echo e(route('users.change_password', auth()->user()->id)); ?>">
                            Change Password
                        </a>
                    </div>
                    <div class="navbar-item">
                        <i class="fas fa-sign-out-alt"></i>&nbsp;<a href="<?php echo e(url('logout')); ?>">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<?php echo $__env->make('layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style type="text/css">
    .transaction_summary {
        padding: 0 10px;
    }
</style>



<script>
// Navbar Resposive Toggle
document.addEventListener('DOMContentLoaded', () => {

  // Get all "navbar-burger" elements
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});

</script>



<?php /**PATH D:\Documents\localhost\www\requisition\resources\views/layouts/header.blade.php ENDPATH**/ ?>