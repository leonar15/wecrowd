<h1>Editing User</h1>
<?php echo Form::open('user/update') ?>

 <p>
    <b>Name:</b>
    <? echo $first_name. ' ' . $last_name; ?>
  </p>

<p>
    <b>Email:</b>
    <? echo $email; ?>
</p>

  <div class="field">
    <label for="campaign_campaign_name">Campaign</label>
    <?php echo form::input('campaign_name',$campaign_name,array('id' => 'campaign_name')) ?>
  </div>
  <div class="field">
    <label for="campaign_description">Description</label>
    <?php echo form::input('description',$description,array('id' => 'description')) ?>
  </div>
  <div class="field">
    <label for="default_donation">Default Donation</label>
    <?php echo form::input('default_donation',$default_donation,array('id' => 'default_donation')) ?>
  </div>
  <div class="actions">
    <?php echo form::submit('submit','Update WeCrowd Account') ?>
  </div>
</form>

<a href="/">Back</a>
