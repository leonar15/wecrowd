<div class="campaigns">
    <h3>Funding Campaigns</h3>
    <? if (empty($campaigns)): ?>
        // deal with empty campaigns here
    <? else: ?>
        <? foreach ($campaigns as $this_campaign): ?>
            <div class="campaign">
                <a href="<?=$this_campaign->getUri()?>">
                    <div class="campaign-name"><?=$this_campaign->name?></div>
                    <div class="description"><?=$this_campaign->description?></div>
                    <div class="merchant-name">by <?=$this_campaign->first_name . ' ' . $this_campaign->last_name?> </div>
                    <div class="goal">Goal: $<?=number_format($this_campaign->total_goal, 2)?></div>
                    <div class="donate">Donate $<?=number_format($this_campaign->default_donation, 2)?></div>
                </a>
            </div>
        <? endforeach ?>
    <? endif ?>
</div>