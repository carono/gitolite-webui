<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "gitolite".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @method static \app\models\Gitolite findOne($condition)
 * @method static \app\models\Gitolite[] findAll($condition)
 */
class Gitolite extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gitolite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['path'], 'string', 'max' => 1024],
            [['path'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'path' => Yii::t('app', 'Path'),
        ];
    }


    
    /**
     * @inheritdoc
     * @return \app\models\query\GitoliteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\GitoliteQuery(get_called_class());
    }


}
