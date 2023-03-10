<?php defined("SITE_URL") or die(); ?>
<div class="py-5 h-100">
<div class="container h-100">
    <div class="text-center" id="step1">
    <img src="assets/img/friend-question.png" style="height:275px" class="mw-100" alt="<?php _e("quizPage"); ?>">
    <h1 class="my-4"><?php _e("quizPage"); ?></h1>
    <p class="mb-0"><?php _e("quizPageText"); ?></p>
    <?php if(count($questions) > 0): ?>
    <form action="" id="startForm" method="post">
    <div class="my-4 row justify-content-center">
        <div class="input-group col-lg-6">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input required="" id="userName" class="form-control" placeholder="<?php _e("enterYourName"); ?>" type="text">
        </div>
    </div>
    <button class="btn btn-primary" type="submit" style="margin-top:10px;"><?php _e("createQuizButton"); ?></button>
    </form>
    <?php else: ?>
    <div class="alert alert-danger mt-4 d-inline-block"><?php _e("noQuestionsFound"); ?></div>
    <?php endif; ?>
    </div>
    <div class="text-center" id="question" style="display:none">
        <h5 class="mb-0 text-primary font-weight-light" id="questionRange"></h5>
        <h1 class="my-4" id="questionText"></h1>
        <button class="mb-4 btn btn-primary" onclick="changeQuestion()"><?php _e("changeQuestion"); ?><i class="fas fa-arrow-right ml-1"></i></button>
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
</div>
</div>
<script type="text/javascript">var questions = <?php echo json_encode($questions); ?>;var question_limit = <?php echo $Configs["question_limit"]; ?>;</script>
<script type="text/javascript" src="assets/js/create-quiz.js"></script>
