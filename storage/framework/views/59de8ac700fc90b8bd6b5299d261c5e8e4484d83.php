<?php if(!empty($spShowFilterSet) && $spShowFilterSet == true): ?>
    <div class="column is-2">
        <div style="display: inline-block; float: right; margin-top: 0px;">
            <div class="level-rights">
                <div class="control">
                    
                    <?php echo e(Form::open(array('url' => $spSearchData ?? NULL,'method' => 'get','value' => 'PATCH','id' => 'search','files' => true,'autocomplete' => 'off'))); ?>


                        <div class="sb-example-1">
                            <div class="search">
                                <input 
                                    id="textboxID" 
                                    name="key" 
                                    type="text" 
                                    class="searchTerm" 
                                    placeholder="What are you looking for?" 
                                    value="<?php echo e(request()->get('key') ? request()->get('key') : ''); ?>">
                                <button 
                                    type="submit" 
                                    class="searchButton">
                                        <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>                
                    <?php echo e(Form::close()); ?>       
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
            document.getElementById('textboxID').select();
        </script>
    </div>
<?php endif; ?>
<?php /**PATH D:\Documents\localhost\www\requisition\resources\views/component/filter_set.blade.php ENDPATH**/ ?>