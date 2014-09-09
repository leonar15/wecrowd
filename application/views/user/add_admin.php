
<h1>Admin and Campaign registration</h1>
<?php echo Form::open('user/complete_admin_registration') ?>

  <div class="field">
    <label for="campaign_first_name">First Name</label>
    <?php echo Form::input('first_name', '',array('id' => 'first_name')) ?>
  </div>

   <div class="field">
    <label for="campaign_last_name">Last Name</label>
    <?php echo Form::input('last_name','',array('id' => 'last_name')) ?>
  </div>

  <div class="field">
    <label for="campaign_campaign_name">Campaign Name</label>
    <?php echo Form::input('campaign_name','',array('id' => 'campaign_name')) ?>
  </div>

  <div class="field">
    <label for="campaign_description">Campaign Descripion</label>
    <?php echo Form::input('description','' ,array('id' => 'description')) ?>
  </div>

    <div id="registration_wrap" class="field" >
      <div id="step3">
        <label for="default_donation">Default Donation</label>
        <?php echo Form::input('default_donation','',array('id' => 'default_donation')) ?>

        <label for="campaign_email">Email</label>
        <?php echo Form::input('email','',array('id' => 'email')) ?>

        <label for="campaign_password">Password</label>
        <?php echo Form::password('password','',array('id' => 'password')) ?>
      </div>
  </div>

  <div class="field">
      <label for = "campaign_account_type"> Account Type </label>
      <?php echo Form::select('account_type',array( 'personal'  =>' Individual', 'business' => 'Business'), false, array('id' => 'account_type')) ?>

</div>

  <div id="registration_wrap" >
    <div id="step4" class="actions">
      <?php echo Form::submit('submit','Create Admin and Campaign') ?>
    </div>
  </div>
</Form>

<a href="/">Back</a>