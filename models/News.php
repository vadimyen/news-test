<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id #
 * @property string $title Название
 * @property string $body Текст
 * @property string $created_at Дата новости
 * @property string|null $update_at Последнене обновление
 * @property int $favorite Избранное
 * @property string|null $img Изображение
 * @property int|null $topic_id # темы
 *
 * @property Topic $topic
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'update_at'], 'safe'],
            [['favorite', 'topic_id'], 'integer'],
            [['title', 'img'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'title' => 'Название',
            'body' => 'Текст',
            'created_at' => 'Дата новости',
            'update_at' => 'Последнене обновление',
            'favorite' => 'Избранное',
            'img' => 'Изображение',
            'topic_id' => '# темы',
        ];
    }

    /**
     * Gets query for [[Topic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}
