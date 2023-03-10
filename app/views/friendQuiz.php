<?php defined("SITE_URL") or die(); ?>
<div class="py-5 h-100">
<div class="container h-100">
    <div class="text-center" id="step1">
    <?php if(isset($_COOKIE[$quiz["shortcode"]]) && $_COOKIE[$quiz["shortcode"]] == "1"): ?>
        <h1><i class="fas fa-poll fa-2x text-primary mb-4"></i></h1>
        <h1 class="mb-4"><?php _e("friendKnow"); ?></h1>
        <p class="mb-0"><?php _e("friendKnowText"); ?></p>
    <?php else: ?>
    <?php if(isset($_COOKIE[$quiz["shortcode"]])): ?>
    <?php $parts = explode("=", $_COOKIE[$quiz["shortcode"]]);
    if(count($parts) == 2) {
        $username = strip_tags($parts[0]);
        $score = intval($parts[1]);
    }
    else {
        $username = "NULL";
        $score = 0;
    }
    $question_count = count($quiz["questions"]);
    $p = floor(($score/$question_count)*100);
    ?>
    <h1 class="mb-4"><?php echo sprintf($Strings->g("friendQuizTest"), $quiz["username"]); ?></h1>
    <div class="progress mx-auto mt-3" style="box-shadow:none!important" data-value="<?php echo $p; ?>">
          <span class="progress-left">
              <span class="progress-bar border-primary"></span>
          </span>
          <span class="progress-right">
              <span class="progress-bar border-primary"></span>
          </span>
          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
            <div class="h2 font-weight-bold mb-0 text-primary"><?php echo $Configs["language"] == "tr" ? "%".$p : $p."%"; ?></div>
          </div>
    </div>
    <h1 class="my-4 h2"><?php _e("yourScore"); ?>: <?php echo $score."/".$question_count; ?></h1>
    <?php else: ?>
    <h1 class="my-4"><?php echo sprintf($Strings->g("friendQuizTest"), $quiz["username"]); ?></h1>
    <p class="mb-0"><?php echo sprintf($Strings->g("friendQuizText") ,$quiz["username"]); ?></p>
    <form action="" id="startForm" method="post">
    <div class="my-4 row justify-content-center">
        <div class="input-group col-lg-6">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input required="" id="userName" class="form-control" placeholder="<?php _e("enterYourName"); ?>" type="text">
        </div>
    </div>
        <button class="btn btn-primary" type="submit"><?php _e("doQuiz"); ?></button>
    </form>
    <?php endif; ?>
    <?php endif; ?>
    <div class="row justify-content-center">
    <div class="my-4"><?php echo $Configs["score_ad"]; ?></div>
    <div class="col-lg-6 table-responsive mt-4">
        <table class="table">
            <thead>
            <tr><th colspan="2" class="h5"><?php _e("scoreTable"); ?></th></tr>
            <tr><th><?php _e("scoreName"); ?></th><th><?php _e("score"); ?></th></tr>
            </thead>
            <tbody>
            <?php if(isset($quiz["scores"]) && count($quiz["scores"]) > 0): ?>
            <?php foreach($quiz["scores"] as $score): ?>
            <tr>
                <td><?php echo $score["username"]; ?></td>
                <td><?php echo $score["score"]."/".count($quiz["questions"]); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="2"><?php _e("scoreEmpty"); ?></td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>
    <?php if(!isset($_COOKIE[$quiz["shortcode"]])): ?>
    <div class="text-center" id="question" style="display:none">
        <h5 class="mb-0 text-primary font-weight-light" id="questionRange"></h5>
        <h1 class="my-4" id="questionText"></h1>
        <div class="row text-center justify-content-center" id="questionAnswers">
        <div class="col-lg-3 p-2" style="display:none" onclick="answerQuestion(:index)">
            <div class="rounded d-flex align-items-center justify-content-center text-center">
            <div>
            <img class="w-100 rounded-top" style="height:170px;display:none" src="data:image/gif;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA="/>
            <h3 class="font-weight-normal my-3 mb-0">:text</h3>
            </div>  
            </div>
        </div>
        </div>
    </div>
    <div class="text-center h-100 align-items-center justify-content-center" id="step2" style="display:none">
    <div>
    <div class="preloader"></div>
    <h1 class="my-4"><?php _e("pleaseWaitText"); ?></h1>
    </div>
    </div>
    <?php endif; ?>
</div>
</div>
<?php if(!isset($_COOKIE[$quiz["shortcode"]])): ?>
<script type="text/javascript">
var questions = <?php echo json_encode($quiz["questions"]); ?>;
var shortcode = "<?php echo $quiz["shortcode"]; ?>";
</script>
<script type="text/javascript" src="assets/js/friend-quiz.js"></script>
<?php endif; ?>
