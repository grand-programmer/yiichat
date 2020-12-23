<?php
use yii\widgets\ActiveForm;

$this->title = 'Messages';
?>
    <div class="container">
        <?php $form = ActiveForm::begin(['action'=>'/chat/create']); ?>
        <div class="row chat">
            <div class="col-sm-12">
                <div class="chatbody">
                    <div class="panel panel-primary">
                        <div class="panel-heading top-bar">
                            <div class="col-md-12 col-xs-12">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat</h3>
                            </div>
                        </div>
                        <div class="panel-body msg_container_base">
                            <?php foreach($messages as $message):?>
                                <?php if(Yii::$app->user->identity->role==\common\models\User::ROLE_ADMIN or $message->status==1): ?>
                                    <?php if(Yii::$app->getUser()->id==$message->sender):?>
                                        <div class="row msg_container base_sent <?= (\common\models\User::isAdmin($message->sender))?"admin-message":""?>">
                                            <div class="col-md-11 col-xs-11">
                                                <div class="messages msg_sent">
                                                    <p><?=$message->text ?></p>
                                                    <?php
                                                    if(Yii::$app->user->identity->role==\common\models\User::ROLE_ADMIN): ?>
                                                        <a class="correct-wrong" onclick="correct(<?=$message->id?>,this);"><?= ($message->status==1)?"Корректный":"Не корректный" ?></a>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-xs-1 avatar">
                                                <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                                            </div>
                                        </div>
                                    <?php else:?>
                                        <div class="row msg_container base_receive <?= (\common\models\User::isAdmin($message->sender))?"admin-message":""?>">
                                            <div class="col-md-1 col-xs-1 avatar">
                                                <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                                            </div>
                                            <div class="col-md-11 col-xs-11">
                                                <div class="messages msg_receive">
                                                    <p><?=$message->text ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;
                                endif; ?>

                            <?php endforeach;?>
                            <?php  if(Yii::$app->user->identity->role==\common\models\User::ROLE_ADMIN): ?>
                                <script type="text/javascript">
                                    function correct(message_id,el){
                                        $.ajax({
                                            url: '/chat/correct',
                                            type: 'post',
                                            dataType: 'json',
                                            data: {'id':message_id },
                                            success: function (response) {
                                                if(response.text)
                                                    el.text=response.text;
                                            },
                                        });
                                    }

                                </script>
                            <?php endif; ?>
                        </div>
                        <div class="panel-footer">
                            <?php if(!Yii::$app->user->isGuest): ?> <div class="input-group">

                                <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." name="Messages[text]" />
                                <?= $form->field($model,'sender')->hiddenInput(['value'=>Yii::$app->getUser()->id])->label(false);?>
                                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-chat"><i class="fa fa-send fa-1x" aria-hidden="true"></i></button>
                        </span>

                            </div>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
