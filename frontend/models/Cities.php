<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $city
 * @property float|null $lat
 * @property float|null $long
 *
 * @property Tasks[] $tasks
 * @property Users[] $users
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city'], 'required'],
            [['lat', 'long'], 'number'],
            [['city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['city_id' => 'id']);
    }
}
