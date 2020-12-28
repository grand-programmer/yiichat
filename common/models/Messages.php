<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int|null $sender
 * @property string|null $text
 * @property int|null $status
 */
class Messages extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender'], 'integer'],
            [['status'], 'boolean'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['text','sender'],'filter','filter'=>'\yii\helpers\HtmlPurifier::process'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => 'Sender',
            'text' => 'Text',
            'status' => 'Корректный',
        ];
    }
    public function changeStatus(){
        if($this->status)
            $this->status = false;
        else
            $this->status = true;
    }
}
