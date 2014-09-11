<h1>Welcome to WeCrowd</h1>
<p>You can browse different fundraising campaign. If you want to start your own campaign, please register.</p>

<!-- Button to trigger modal -->
<a href="#myModal" role="button" class="btn btn-demo-launch" data-toggle="modal">
    Launch demo
</a>
 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><center>Modal header</center></h3>
  </div>
  <div class="modal-body">
    <p>
        <a href="javascript:void(0);" onclick="startIntro();" class="btn btn-demo btn-large" data-dismiss="modal">
            Demo as Merchant
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="startIntro2();" class="btn btn-demo-buyer btn-large" data-dismiss="modal">
            Demo as Payer
        </a>
    </p>
  </div>
</div>
<?=$featured_campaigns?>
<script type="text/javascript">
function startIntro(){
    var intro = introJs();
    intro
        .setOptions({
            steps: [
                { 
                    intro: "Hello! Let's take a look at the onboarding process as a merchant who wants to accept donations!"
                },
                {
                    intro: "Let's begin by registering as a merchant!"
                }
            ],
            showStepNumbers: false,
            doneLabel: 'Next Page'
        })
        .oncomplete(function() {
            window.location.href = '/campaign/new?demo=true';
        })
        .start();
}
function startIntro2() {
    var intro = introJs();
    intro.setOptions({
        steps: [
            {
                intro: "Hello! Let's take a look at the buying process."
            },
        ],
        showStepNumbers: false
    })
    .oncomplete(function() {
      window.location.href = '/user/account/71?demo=true';
    })
    .start();
}
</script>
