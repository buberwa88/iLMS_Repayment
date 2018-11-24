<?php

namespace frontend\modules\appeal\models;

/**
 * This is the ActiveQuery class for [[Appeal]].
 *
 * @see Appeal
 */
class AppealQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Appeal[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Appeal|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
