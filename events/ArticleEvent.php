<?php

namespace app\events;

use yii\base\Event;
use app\models\Articles;

class ArticleEvent extends Event
{
    /**
     * @var Articles
     */
    private $_article;

    /**
     * @return Articles
     */
    public function getArticle()
    {
        return $this->_article;
    }

    /**
     * @param Articles $article
     */
    public function setArticle(Articles $article)
    {
        $this->_article = $article;
    }
}