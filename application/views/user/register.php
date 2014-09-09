<?php
  echo HTML::style('content/css/introjs-nassim.css');
  echo HTML::script('content/js/intro.js');
  $config = Kohana::$config->load('users');
  $user = $config[0]; ?>

<h1>WeCrowd registration</h1>
<?php echo Form::open('user/complete_registration') ?>

  <div class="field">
    <label for="campaign_first_name">First Name</label>
    <?php echo Form::input('first_name', $user['first_name'],array('id' => 'first_name', 'readonly' => true)) ?>
  </div>

   <div class="field">
    <label for="campaign_last_name">Last Name</label>
    <?php echo Form::input('last_name',$user['last_name'],array('id' => 'last_name', 'readonly' => true)) ?>
  </div>

  <div class="field">
    <label for="campaign_campaign_name">Campaign Name</label>
    <?php echo Form::input('campaign_name',$user['campaign_name'],array('id' => 'campaign_name', 'readonly' => true)) ?>
  </div>

  <div class="field">
    <label for="campaign_description">Campaign Descripion</label>
    <?php echo Form::input('description',$user['campaign_description'],array('id' => 'description', 'readonly' => true)) ?>
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

 <div class="field">
    <?php echo Form::input('demo',$demo,array('id' => 'demo', 'type' => 'hidden')) ?>
  </div>

  <div id="registration_wrap" >
    <div id="step4" class="actions">
      <?php echo Form::submit('submit','Create Campaign') ?>
    </div>
  </div>
</Form>

<a href="/">Back</a>

<script type="text/javascript"> 
  if (RegExp('demo=true', 'gi').test(window.location.search)) {
    var intro = introJs();
    intro.setOptions({
      steps: [
        {
          intro: "To make things easier, we have already prefilled parts of the registration."
        },
        {
          element: '#step3',
          intro: 'You can fill out the rest! Please provide your real email address in order to receive the confirmation email.',
          position: 'right'
        },
        {
          element: '#step4',
          intro: "After registering, 'user/register' is called and an access token is passed to the account/create/ call.",
        }
      ],
      showStepNumbers: false
    })
    intro.start();

  }
</script>
