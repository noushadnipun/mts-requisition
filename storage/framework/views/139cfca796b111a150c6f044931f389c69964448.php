<?php $__env->startSection('title'); ?>
    Sites
<?php $__env->stopSection(); ?>
<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('sites.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Sites',
            'spSubTitle' => 'all sites here',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addUrl,
            'spAllData' => route('sites.index'),
            'spSearchData' => route('sites.search'),
            'spTitle' => 'Sites',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
        <div class="column is-1">
            <div class="level-item is-4">
                    <a href="<?php echo e(route('sites.import')); ?>" class="button is-small is-warning is-rounded" aria-haspopup="true" aria-controls="dropdown-menu3">
                    <span><i class="fas fa-plus"></i> Import</span>
                </a>
            </div>

        </div>
        <?php endif; ?>

        <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id) || auth()->user()->isAccountant(auth()->user()->id)): ?>
            <div class="column is-1">
                <div class="level-item is-4">
                    <a href="<?php echo e(route('sites.export.excel')); ?>" class="button is-small is-primary is-rounded" aria-haspopup="true" aria-controls="dropdown-menu3">
                        <span><i class="fas fa-download"></i> Export as Excel</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search sites...',
            'spAddUrl' => route('sites.create'),
            'spAllData' => route('sites.index'),
            'spSearchData' => route('sites.search'),
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    <?php if(!empty($sites)): ?>
        <div class="columns is-multiline">
            <?php
                //dd($sites);
                if(auth()->user()->isManager(auth()->user()->id)) {
                    $manager_id = auth()->user()->id;

                    if(request()->get('key')) {
                        $default = [
                            'search_key' => request()->get('key') ?? '',
                            'limit' => request()->get('limit') ?? 10,
                            'offset' => request()->get('offset') ?? 0
                        ];
                        $no = $default;

                        $key = $no['search_key'];
                        $limit = $no['limit'];
                        $offset = $no['offset'];

                        $sitesss = \Tritiyo\Site\Models\Site::leftjoin('projects', 'projects.id', 'sites.project_id')
                                    ->leftjoin('users', 'users.id', 'projects.manager')
                                    ->select('sites.*', 'projects.name', 'projects.code', 'projects.type', 'projects.customer','users.name')
                                    ->where('projects.manager', $manager_id)
          							->orderBy('sites.id', 'desc')
                                    ->where(function($query) use ($key) {
                                            $query->where('sites.project_id' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('sites.location' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('sites.site_code' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('sites.material' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('sites.site_head' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('sites.budget' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('sites.completion_status' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('projects.name' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('projects.code' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('projects.type' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('projects.customer' ,'LIKE', '%'.$key.'%');
                                            $query->orWhere('users.name' ,'LIKE', '%'.$key.'%');
                                    })
                                    //->toSql();
                                    //->paginate('48');
          							->get();

                                    //dd($sitesss);

                    } else {
                        $sitesss = \DB::table('sites')->leftJoin('projects', 'projects.id', 'sites.project_id')
                                    ->select('sites.*', 'projects.manager')
                                    ->where('projects.manager', $manager_id)
                                    ->groupBy('sites.project_id')
                                    ->groupBy('sites.id')
                                    ->paginate(48);
                    }
                } else {
                    $sitesss = $sites;
                }

            ?>
            <?php $__currentLoopData = $sitesss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('site::index_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="pagination_wrap pagination is-centered">
            <?php if(Request::get('key')): ?>
          			<?php 
          				$appendRequest = [
                          'key' => Request::get('key'),
                          'limit' => Request::get('limit') ?? 48,
                          'offset' => Request::get('offset') ?? 0
                        ];
          			//echo $sitesss->withQueryString()->appends($appendRequest)->links('pagination::bootstrap-4');
          			//exit();
          //{{$sitesss->withQueryString()->appends()->links('pagination::bootstrap-4') }}
          			?>
                  
            <?php else: ?>
                <?php echo e($sitesss->links('pagination::bootstrap-4')); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/index.blade.php ENDPATH**/ ?>