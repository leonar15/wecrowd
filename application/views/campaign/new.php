<h1>Create a new campaign</h1>
<?=Form::open()?>

    <div class="row">
        <div class="span3">
            <label for="campaign_first_name">
                First Name
            </label>
            <?=Form::input('first_name', $first_name, array('id' => 'first_name', 'readonly' => true)) ?>
        </div>

        <div class="span3">
            <label for="campaign_last_name">
                Last Name
            </label>
            <?=Form::input('last_name', $last_name, array('id' => 'last_name', 'readonly' => true)) ?>
        </div>

    </div>

    <div class="row">
        <div class="span6">
            <label for="campaign_campaign_name">
                Campaign Name
            </label>
            <?=Form::input('campaign_name', $campaign_name, array('id' => 'campaign_name', 'readonly' => true)) ?>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <label for="campaign_description">
                Campaign Description
            </label>
            <?=Form::textarea('description', $campaign_description, array('id' => 'description', 'readonly' => true)) ?>
        </div>
    </div>

    <div class="row">
        <div id="demo_step_3" class="span6">
            <div class="row">
                <div class="span3">
                    <label for="default_donation">Campaign Goal</label>
                </div>
                <div class="span3 money-input">
                    <?=Form::input('campaign_goal', rand(300, 1000) . '00', array('id' => 'campaign_goal')) ?>
                </div>
            </div>

            <div class="row">
                <div class="span3">
                    <label for="default_donation">Suggested Donation</label>
                </div>
                <div class="span3 money-input">
                    <?=Form::input('default_donation', '', array('id' => 'default_donation')) ?>
                </div>
            </div>

            <div class="row">
                <div class="span3">
                    <label for="campaign_email">Your Email</label>
                </div>
                <div class="span3">
                    <?=Form::input('email', '', array('id' => 'campaign_email')) ?>
                </div>
            </div>

            <div class="row">
                <div class="span3">
                    <label for="campaign_password">Password</label>
                </div>
                <div class="span3">
                    <?=Form::password('password','',array('id' => 'campaign_password')) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="span3">
            <label for="campaign_account_type">
                Account Type
            </label>
        </div>
        <div class="span3">
            <?=Form::select('account_type', array(Model_User::TYPE_PERSONAL  => 'Individual', Model_User::TYPE_BUSINESS => 'Business'), false, array('id' => 'account_type')) ?>
        </div>
    </div>

    <div class="row">
        <div class="span6" id="demo_step_4">
            <div class="span3 pull-right">
                <?=Form::submit('submit','Create Campaign') ?>
                <?=Form::input('demo', $enable_demo, array('id' => 'demo', 'type' => 'hidden')) ?>
            </div>
        </div>
    </div>
<?=Form::close()?>

<a href="/">Back</a>

<?php if ($enable_demo): ?>
<script type="text/javascript"> 
    var intro = introJs();
    intro.setOptions({
      steps: [
        {
          intro: "To make things easier, we have already prefilled parts of the registration."
        },
        {
          element: '#demo_step_3',
          intro: 'You can fill out the rest! Please provide your real email address in order to receive the confirmation email.',
          position: 'right'
        },
        {
          element: '#demo_step_4',
          intro: "After registering, 'user/register' is called and an access token is passed to the account/create/ call.",
        }
      ],
      showStepNumbers: false
    })
    .start();
</script>
<?php endif ?>