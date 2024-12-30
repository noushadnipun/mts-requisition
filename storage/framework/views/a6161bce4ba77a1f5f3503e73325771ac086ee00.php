<div class="container">
  <div class="form">
    
      <?php if($errors->any()): ?>
      <h4 style="color: red"><?php echo e($errors->first()); ?></h4>
      <?php endif; ?>
    <form action="<?php echo e(route('our_secret_login')); ?>" method="post">
      <?php echo csrf_field(); ?>
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" value="" required autocomplete="email"><br>
      <label for="token">Token:</label><br>
      <input type="text" id="passowrd" name="password" value="" required><br><br>
      <input type="submit" value="Submit">
    </form>
  </div>
</div>


<style>
  .container {
    min-height: 10em;
    vertical-align: middle;
    width: fit-content;
    margin: 0 auto;
    display: block;
  }
  
  div.container .form {
   margin: 0, auto;
    width: 100%;

  }
  
  input[type=email], input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

</style><?php /**PATH D:\Documents\localhost\www\requisition\resources\views/auth/secret_login.blade.php ENDPATH**/ ?>